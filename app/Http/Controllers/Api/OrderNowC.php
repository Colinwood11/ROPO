<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\OrderingNow;
use App\Models\OrderVariant;
use App\Models\TableHistory;
use App\Models\PrinterQueue;
use App\Models\PrinterUpdate;
use App\Models\Dish;
use App\Models\Table;
use App\Models\PrinterCache;
use App\Models\OrderInvoice;
use App\Models\OrderQue;


use App\Http\Requests\insert\order_insert;
use App\Http\Requests\update\order_update;
use App\Http\Requests\delete\order_delete;
use App\Http\Requests\insert\order_insert_staff;
use App\Http\Requests\update\order_confirm;
use App\Http\Requests\update\order_confirm_staff;
use App\Http\Requests\order_cash;
use App\Models\DishMenu;
use App\Models\Menu;
use App\Models\OrderUpdate;
use App\Models\PrintContent;
use App\Models\PrinterUpdateContent;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Cache\Events\CacheEvent;
use Illuminate\Support\Facades\Log;

class OrderNowC extends ApiController
{
    public function __construct()
    {
        $this->_model = new OrderingNow;
        $this->TableNumberLitmitTime = 2; // minutes
        $this->RegularTime = 5;             //regular frequency
        $this->RegularLimit = 2;            //mininum frequancy
        $this->RegularMinimunThreshold = 3; // num dishes
    }
    public function GetAllUnfinished()
    {
        $result = $this->_model->GetUnfinished()->keyBy('id');
        return $result;
    }

    protected function array_processing($data_array, $table_history_id)
    {

        $final_dish = array();
        $now = Carbon::now();
        $cart_ids = array_column($data_array,'dish_id');
        $dish_all = (new DishC)->GetAll()->whereIn('id', $cart_ids)->keyBy('id');
        #Assigning the price
        foreach ($data_array as &$dish) {
            #case2: not existing yet, adding all dish and menu data and set number to 1
            $price = 0;
            $menu = $dish_all[$dish['dish_id']]->dish_menu->where('menu_id', $dish['menu'])->first();
            if ($dish_all[$dish['dish_id']]->IsDiscount($dish['menu'])) {
                $price = $menu->discounted_price;
            } else {
                $price = $menu->price;
            }

            $dish['price'] = $price;
            $dish['order_at'] = $now;
            $dish['status'] = '0';  #default pending from the guest
            $dish['table_history_id'] = $table_history_id;
        }
        return $data_array;
    }

    protected function CheckDishLimit(&$dishes_array,$table_history,$dish_model)
    {
        //For each dish check if has set the limit, if yes then sum the number from orderque and ordernow and this order
        $unset_keys = [];
        foreach($dishes_array as $key => &$dish_order)
        {   
            $dish_menu = $dish_model[$dish_order['dish_id']]['dish_menu']->where('menu_id',$dish_order['menu'])->first();
            
            if(isset($dish_menu) && isset($dish_menu->limit))
            {
                $num_person = ceil($table_history->num_person);
                $que_number = $table_history->orderque->where('dish_id',$dish_order['dish_id'])->where('menu',$dish_order['menu'])->sum('number');
                $ordernow_number = $table_history->orderingNow->where('dish_id',$dish_order['dish_id'])->where('menu',$dish_order['menu'])->sum('number');
                $limit = $num_person*$dish_menu->limit;
                $ordered_number = $que_number+$ordernow_number;
                if($ordered_number+$dish_order['number'] > $num_person*$dish_menu->limit)
                {
                    //如果之前点单的总和已经超过了限制，记录并在之后删除这个菜。
                    if($ordered_number >= $limit){
                        $unset_keys[] = $key;
                    }
                    //如果加上目前的菜超出，则减去目前菜的数量来满足限制。
                    else{
                        $dish_order['number'] = $limit-$ordered_number;
                    }

                    //return [false,$dish_model[$dish_order['dish_id']]['name']];
                }
            }
        }
        
        foreach($unset_keys as $key)
        {
            unset($dishes_array[$key]);
        }
        
        return [true];
    }

    protected function checkFrequency($table_history,$OrderArray)
    {
        //under no limit interval do nothing
        //小于最低时间之内为[桌子人数+1]频率限制
        //if is more than limit interval restrict order frequency:[5 minutes][2 times][min 3 dishes]
        //之后开启点单频率限制
        #$x_minutes_ago = Carbon::now()->subMinutes($this->TableNumberLitmitTime);
        #$order_recent = $table_history->OrderingNow->where('order_at', '>=', $x_minutes_ago)->pluck('order_at')->unique();
        #$order_limit = $table_history->num_person + 1;
#
        #if ($x_minutes_ago->lt(Carbon::parse($table_history->start_time))) {           
        #    if (isset($order_recent) && count($order_recent) > $order_limit) {
        #        //dd('check not passed, recent history beyond');
        #        return (['result'=>false,'messagge' => 'too much orders (recent)','code'=>429]);
        #    }
        #    //dd('check passed, recent history within limit');
#
        #} else {
#
        #    #dump('old history proceed to check regular mode');
        #    $order_recent = $table_history->OrderingNow->where('order_at', '>=', Carbon::now()->subMinutes($this->RegularTime))->pluck('order_at')->unique();
        #    if (count($order_recent) > $this->RegularLimit) {
        #        //'regular check not passed'
        #        return (['result'=>false,'messagge' => 'too frequent orders','code'=>429]);
        #    } 
        #    #else {
        #    #    if (count($OrderArray['cart']) < $this->RegularMinimunThreshold) {
        #    #        return (['result'=>false,'messagge' => 'too less orders','code'=>400]);
        #    #    }
        #    #}
        #}
        return ['result'=>true];
    }

    public function receive_insert(order_insert $request)
    {
        $printer_data_global = array();                //data for printer
        $OrderArray = $request->all();
        $table_history_id  = null;
        $merge_interval  = Settings::GetMergeInterval();
        $merge_interval = isset($merge_interval)? $merge_interval:0;
        #Auth and check
        if (isset($OrderArray['code'])) {
            unset($OrderArray['code']);
        } else {
            //no table->asporto
            $OrderArray['table_history_id']  = TableHistory::create(['table_id' => null, 'start_time' => Carbon::now(), "end_time" => null, 'note' => $OrderArray['note']]);
            $printer_data_global['note'] = $OrderArray['note'];
        }
        $table_history = TableHistory::with(['table', 'orderingNow','orderque'])->find($OrderArray['table_history_id']);
        $user = Auth::user();
        if($user == null || $user->HasOrGreaterRole('waiter') == false){
            if($merge_interval > 0){
                $result = $this->checkFrequency($table_history,$OrderArray);
            }
            else
            {
                $result['result'] = true;
            }
            if(!$result['result'])
            {
                unset($result['result']);
                $code = $result['code'];
                unset($result['code']);
                return response($result,$code);
            }
        }

        #parsing data
        $dishes = array();
        $OrderArray['cart'] = $this->array_processing($OrderArray['cart'], $OrderArray['table_history_id']);
        $dishes = array_unique(array_column($OrderArray['cart'],'dish_id'));
        $dishes_model = Dish::with(['dish_menu'])->WhereIn('id', $dishes)->where('status',0)->get()->keyBy('id');

        #check the order limit
        if($user == null || $user->HasOrGreaterRole('waiter') == false ){
            $check_res = $this->CheckDishLimit($OrderArray['cart'],$table_history,$dishes_model);
            if($check_res[0] == false)
            {
                return response(['messagge' => 'superamento limite d\'ordine del piatto '.$check_res[1]], 403); 
            }
        }
        

        #$table_history = TableHistory::with(['table'])->find($OrderArray['table_history_id']);
        $printer_data['table_number'] = isset($table_history->Table) ? $table_history->Table->number : null;
        $printer_data['created_at'] = Carbon::Now();
        $printer_data['cluster_id'] = PrinterCache::getMaxCluster()?PrinterCache::getMaxCluster()+1:1;
        $dish_printers = $dishes_model->pluck('printer')->unique();
        #setup for printers
        foreach ($dish_printers as $pos => $printer) {

            $dish_this_printer = $dishes_model->filter(function ($dish) use ($printer) {
                return $dish->printer == $printer;
            })->pluck('id');

            $printer_data['order_ids'] = '';
            $printer_data['printer'] = $printer;
            
            #添加订单：添加到打印【等待】列表
            $cache[$printer] = PrinterCache::create($printer_data);
        }

        foreach ($OrderArray['cart'] as &$order) {

            $order['user_id'] = isset($order['user_id']) ? $order['user_id'] : null;
            $order['created_at'] = Carbon::now(); #maybe not useful...
            $order['cache_id'] = 'id';
            $variants = array();
            unset($_COOKIE['OrderNow']);
            $order['cache_id'] = $cache[$dishes_model[$order['dish_id']]->printer]->id;
        }

        $new_order = OrderQue::insert($OrderArray['cart']);
        //大于0则有合并冷却时间，如果没有合并冷却则立刻合并
        if($merge_interval > 0){
            //合并时间计算
            $order_times = PrinterCache::GetOrderTimes($table_history->table->number);
            $x_minutes_ago = Carbon::now()->subMinutes($this->TableNumberLitmitTime);
            $stringdata = $x_minutes_ago->format('Y-m-d H:i:s');
            $times = count(OrderingNow::GetOrderTimes($table_history->id,$stringdata));
            $total_times = $order_times+$times;
                //如果超时了，则合并
                if ($x_minutes_ago->lt(Carbon::parse($table_history->start_time))) {
                    if ($total_times == $table_history->num_person) 
                    {    
                        PrinterCache::ManualMerge($printer_data['table_number']);
                    }
                }
            }
        else{
            PrinterCache::ManualMerge($printer_data['table_number']);
            
        }
        $table_history->last_order = Carbon::now();
        $table_history->save();

        return response(['messagge' => 'ok'], 200);
    }

    public function ReceiveInsertStaff(order_insert_staff $request)
    {
        $data = $request->all();
        $data = $this->array_processing($data, $request->table_history_id);
        //TODO

    }

    public function confirm_order(order_confirm $request)
    {
        $this->_model->ConfirmOrder($request->id, $request->que_number);
        return ['messagge' => 'success'];
    }

    public function StaffConfirm(order_confirm_staff $request)
    {
        $this->_model->ConfirmOrder($request->id, $request->que_number);
        return ['messagge' => 'success'];
    }

    protected function cash_order(order_cash $request)
    {
        $order_data = $request->ids;
        if(($request->ids == null || count($request->ids) ==0) && ($request->queids == null || count($request->queids) == 0)){
            return response(['messagge' => 'no ordini da incassare'],400);
        }

        if(isset($order_data[0]['id'])){
            $OrderTableHistory = (new OrderingNow)->GetDetail($order_data[0]['id'])->TableHistory;
        }
        else{
            $OrderTableHistory = OrderQue::GetWithHistory($request->queids[0]['id'])->TableHistory;
        }
        
        if(isset($request->queids) && count($request->queids)>0){
            //进程锁防止merge线程race condition
            $OrderTableHistory->lock_history(); 
            $last_id = null;
            $que_ids = [];
            foreach($request->queids as $que_id){
                //TODO:bulk Query
                $last_id = $que_id['id'];
                $que_ids[] =$que_id['id'];
                $que_id['id'] = OrderQue::MoveToOrderNow($que_id['id']);
                $order_data[] = $que_id;
                
            }
            
            //dump($last_id);
            $cache = OrderQue::with(['PrinterCache.OrderQue'])->find($last_id)->PrinterCache;
            OrderQue::whereIn('id',$que_ids)->delete();
            
            if(count($cache->OrderQue) == 0){
                $cache->delete();
            }
        }

        $order_ids = array_column($order_data,'id');
        $validated_ids = OrderingNow::MakeInvoiceOrder($order_data,$request->num_person,$OrderTableHistory);        
        $table_number = null;
        $table = $OrderTableHistory->Table;
        if(isset($table)){
            $table_number = $table->number;
        }
        
        $model = (new OrderInvoice);
        $model->parseOrders($validated_ids);
        $model->old = 0;
        $model->save();
        PrinterQueue::create(['printer'=>0,'order_ids' => $model->id,'table_number'=>$table_number,'type'=>1]);
        $OrderTableHistory->unlock_history();
        return response(['messagge' => 'success','id'=>$model->id],201);
    }

    protected function get_all_process(&$collection){

    }


    protected function get_key_process(&$collection)
    {
        
    }


    protected function UpdatePreProcess(array &$data_array)
    {

    }

    public function receive_update(order_update $request)
    {
        $data_array = $request->all();
        if (isset($data_array['variant'])) {
            $orderVariant = (new OrderVariant);
            $orderVariant->DeleteOrderVariant($data_array['id']);
            foreach ($data_array['variant'] as $variant) {

                $orderVariant->create(['ordering_id' => $data_array['id'], 'variant' => $variant['dish_variant_name'], $variant]);
            }
            unset($data_array['variant']);
        }
        

        //检查是否需要打印
        if ($data_array['inform_printer'] == 0){
            //update price
            foreach($data_array['updatelist'] as &$order){

                if(isset($order['menu']) && isset($order['price']) == false){

                    $price = OrderingNow::GetWithMenu($order['id'],$order['menu'])->dish->dish_menu[0]->price;
                    $order['price'] = $price;
                }
            }
        }
        else{

            $ATTRIBUTE_INFORM_PRINTER = ['id'=>0,'number'=>1,'menu'=>2,'table_history_id'=>3,'dish_id'=>4,'type'=>5];
            $ATTRIBUTE_NOT_INFORM_PRINTER = ['id'=>0,'status'=>1,'note'=>2,'price'=>3,'order_at'=>4];
            
            //初始化
            $ToPrintContent = array_map(function($a) use($ATTRIBUTE_INFORM_PRINTER){
                return array_intersect_key($a,$ATTRIBUTE_INFORM_PRINTER);
            }, $data_array['updatelist']);

            //添加索引
            $keytmp = [];
            foreach($data_array['updatelist'] as $elem){
                $keytmp[$elem['id']] = $elem;
            }
            $data_array['updatelist'] = $keytmp;
            
            $PrinterQueues = [];
            //广义化的数组添加，因为每次添加有可能会有多个打印列表，
            //而每个打印机最多会有一个打印列表，所以index将会用打印机id来标记unique。
            $OrderIds = array_column($data_array['updatelist'], 'id');
            $OldOrders = OrderingNow::with(['TableHistory.Table'])->WhereIn('id',$OrderIds)->get()->keyBy('id');

            $Dishes_Array = array_column($data_array['updatelist'], 'dish_id');
            $Dishes =[];
            $OldDishes_Array = array_column($OldOrders->toArray(), 'dish_id');
            foreach($OldDishes_Array as $old_dish){
                $Dishes_Array[] = $old_dish;
            }
            $Dishes = Dish::whereIn('id',$Dishes_Array)->get()->keyBy('id');

            //虽然从已有的统计数据来说menu不会出现2个以上的情况，但是由于menu表的数据比较少，所以干脆全部获取吧！
            $Menus = Menu::all()->keyBy('id');
            
            foreach($ToPrintContent as $key => &$content){
                //因为除了Ordernow的id以外，至少得有一个需要通知打印机的【有效】字段
                if(sizeof($content)>1){
                    $id = $content['id'];
                    unset($content['id']);
                    $content['order_id'] = $id;
                    $que_id = null;
                    $OrderPrinter = $Dishes[$OldOrders[$id]->dish_id]->printer;
                    if(isset($PrinterQueues[$OrderPrinter]) == false){
                        $PrinterQueues[$OrderPrinter] = PrinterQueue::create([

                            'printer' => $OrderPrinter, 
                            'order_ids' => '', 
                            'table_number' => $OldOrders[$id]->TableHistory->table->number, 
                            'status' => 3, 
                            'type' => 2

                        ]);
                    }

                    $que_id = $PrinterQueues[$OrderPrinter]->id;
                    $content['que_id'] = $que_id;
                    //如果数量为0则是删除
                    if(isset($content['number']) && $content['number'] == 0){
                        $content['type'] = -1;
                    }

                    //如果是删除订单就不需要其他花里胡哨的检查了。
                    //防止被逗比post请求耍得团团转：比如选择了删除修改但是却改了菜和桌子之类的智障请求。
                    if(isset($content['type']) && $content['type'] == -1)
                    {
                        $content = [];
                        $content['order_id'] = $id;
                        $content['type'] = -1;
                        PrinterUpdateContent::create([
                            'que_id' => $que_id,
                            'original_number' => $OldOrders[$id]['number'],
                            'attribute' => 'dish',
                            'original_value' =>$Dishes[$OldOrders[$id]->dish_id]->name,
                            'original_value_chn' =>$Dishes[$OldOrders[$id]->dish_id]->name_chn,
                            'type' => -1, //删除菜。
                        ]);
                        $OldOrders[$id]->delete();
                        unset ($ToPrintContent[$key]);
                        continue;
                    }

                    //换菜会有两种情况：一种是新的菜和旧的菜打印机一样（从中餐改成中餐）。
                    //另外一种是新的菜和旧的菜不一样。（从中餐换成寿司或者饮料）
                    if(isset($content['dish_id'])){
                        if($OrderPrinter != $Dishes[$content['dish_id']]->printer ){
                            //新菜的打印机和旧的不一样。
                            //需要在旧菜打印机啥显示删除旧菜，新菜打印机上显示增加新菜。
                            //而且剩余的修改都需要加到新的菜上面
                            $newPrinter = $Dishes[$content['dish_id']]->printer;
                            if(isset($PrinterQueues[$newPrinter]) == false){
                            
                                $PrinterQueues[$newPrinter] = PrinterQueue::create([
                                    'printer' => $newPrinter, 
                                    'order_ids' => '', 
                                    'table_number' => $OldOrders[$id]->TableHistory->table->number, 
                                    'status' => 3, 
                                    'type' => 2
                                
                                ]);
                            }

                            $new_que_id = $PrinterQueues[$newPrinter]->id;
                            //旧的打印机，减少旧菜。
                            PrinterUpdateContent::create([
                                'que_id' => $que_id,
                                'original_number' => $OldOrders[$id]['number'],
                                'dish_name' => $Dishes[$OldOrders[$id]->dish_id]->name,
                                'dish_name_chn' => $Dishes[$OldOrders[$id]->dish_id]->name_chn,
                                'attribute' => 'dish',
                                'type' => -1, //删除旧菜。
                            ]);

                            //添加新菜的情况下需要获取所有的信息：菜名，数量，桌子和menu
                            $newdish_string = '';
                            
                            $newdish_string .= ' Menu:';
                            if(isset($content['menu'])){
                                $newdish_string .=$Menus[$content['menu']]->name;
                            }
                            else{
                                $newdish_string .= $Menus[$OldOrders[$id]->menu]->name;
                            }

                            $newdish_string .= '<br> Quantita\':';
                            if(isset($content['number'])){
                                $newdish_string .= $content['number'];
                            }
                            else{
                                $newdish_string .= $OldOrders[$id]->number;
                            }

                            //新打印机，加新菜和信息。
                            PrinterUpdateContent::create([
                                'que_id' => $new_que_id,
                                'original_number' => $OldOrders[$id]['number'],
                                'dish_name' => $Dishes[$content['dish_id']]->name,
                                'dish_name_chn' => $Dishes[$content['dish_id']]->name_chn,
                                'attribute' => 'dish',
                                'target_value' => $newdish_string,
                                'type' => 1, //添加新菜
                            ]);

                            $data_array['updatelist'][$id]['price'] = $this->setPrice($OldOrders[$id],$content);
                            //跳过整个order到下一个。
                            continue;
                        }
                    }
                    //如果if成功走出=>菜前后修改的打印机是一样的。则和之前一样的进行。
                    foreach($content as $attribute => &$value){

                        $OrderPrinter = $Dishes[$OldOrders[$id]->dish_id]->printer;
                        if(isset($PrinterQueues[$OrderPrinter]) == false){
                            $PrinterQueues[$OrderPrinter] = PrinterQueue::create([
                            
                                'printer' => $OrderPrinter, 
                                'order_ids' => '', 
                                'table_number' => $OldOrders[$id]->TableHistory->table->number, 
                                'status' => 3, 
                                'type' => 2
                            
                            ]);
                        }
                        $que_id = $PrinterQueues[$OrderPrinter]->id;
                        switch ($attribute) {
                            case 'dish_id':
                            //如果之前的菜和现在的菜是一样的打印机。
                            //则需要写从A菜改成B菜。
                            $data_array['updatelist'][$id]['price'] = $this->setPrice($OldOrders[$id],$content);
                            PrinterUpdateContent::create([
                                'que_id' => $que_id,
                                'original_number' => $OldOrders[$id]['number'],
                                'attribute' => 'dish',
                                'dish_name' => $Dishes[$OldOrders[$id]->dish_id]->name,
                                'dish_name_chn' => $Dishes[$OldOrders[$id]->dish_id]->name_chn,
                                'original_value' =>$Dishes[$OldOrders[$id]->dish_id]->name,
                                'original_value_chn' =>$Dishes[$OldOrders[$id]->dish_id]->name_chn,
                                'target_value' => $Dishes[$content['dish_id']]->name,
                                'target_value_chn' => $Dishes[$content['dish_id']]->name_chn,
                                'type' => 0, //更改数值模式。
                            ]);
                            break;

                            case 'menu':
                                $data_array['updatelist'][$id]['price'] = $this->setPrice($OldOrders[$id],$content);
                                PrinterUpdateContent::create([
                                    'que_id' => $que_id,
                                    'original_number' => $OldOrders[$id]['number'],
                                    'dish_name' => $Dishes[$OldOrders[$id]->dish_id]->name,
                                    'dish_name_chn' => $Dishes[$OldOrders[$id]->dish_id]->name_chn,
                                    'attribute' => 'menu',
                                    'original_value' =>$Menus[$OldOrders[$id]->menu]->name,
                                    'target_value' => $Menus[$content['menu']]->name,
                                    'type' => 0, //更改数值。
                                ]);
                            break;
                            
                            case 'table_history_id':
                                //换桌子的情况下，目前不分为添加和删除模式。
                                PrinterUpdateContent::create([
                                    'que_id' => $que_id,
                                    'original_number' => $OldOrders[$id]['number'],
                                    'dish_name' => $Dishes[$OldOrders[$id]->dish_id]->name,
                                    'dish_name_chn' => $Dishes[$OldOrders[$id]->dish_id]->name_chn,
                                    'attribute' => 'table',
                                    'original_value' => $OldOrders[$id]->tableHistory->table->number,
                                    'target_value' => TableHistory::with(['table'])->find($content['table_history_id'])->table->number,
                                    'type' => 0, //更改数值模式。
                                ]);
                            break;
                            
                            case 'number':
                                    //数量只要用普通模式就行了。
                                    PrinterUpdateContent::create([
                                        'que_id' => $que_id,
                                        'original_number' => $OldOrders[$id]['number'],
                                        'dish_name' => $Dishes[$OldOrders[$id]->dish_id]->name,
                                        'dish_name_chn' => $Dishes[$OldOrders[$id]->dish_id]->name_chn,
                                        'attribute' => 'number',
                                        'original_value' =>$OldOrders[$id]->number,
                                        'target_value' => $content['number'],
                                        'type' => 0, //更改数值模式。
                                    ]);

                            break;

                            default:
                            break;
                        }
                    }
                    
                }

            }

            //因为之前的循环里有个跳过循环的条件，所以需要用另外一个循环来填null
            //TODO:在前端用js填上null
            foreach($ToPrintContent as &$content){
                $attrNoid = $ATTRIBUTE_INFORM_PRINTER;
                unset($attrNoid['id']);
                $attrNoid = array_keys($attrNoid);
                foreach($attrNoid as $attr){
                    if(isset($content[$attr])==false){
                        $content[$attr] = NULL;
                    }
                }
            }
            //好像暂时没用
            $NoPrintContent = array_map(function($a) use($ATTRIBUTE_NOT_INFORM_PRINTER){
                return array_intersect_key($a,$ATTRIBUTE_NOT_INFORM_PRINTER);
            }, $data_array['updatelist']);

            foreach($PrinterQueues as &$que){
                $que->status = 0;
                $que->save();
            }

        }
        //打印列表结束后，更改原本旧的数值。
        foreach($data_array['updatelist'] as $order){
            $updContent = $order;
            unset($updContent['id']);
            $ordernow = OrderingNow::find($order['id']);
            //如果是删除订单，则update会报错(因为find结果为null)
            if($ordernow){
                $ordernow->Update($updContent);
            }
        }

        return response(['message'=>'update success'],200);
    }

    protected function setPrice($OldOrder,$content){

        if(!isset($content['price'])){
            $dishId = isset($content['dish_id'])?$content['dish_id']:$OldOrder->dish_id;
            $menuid = isset($content['menu'])?$content['menu']:$OldOrder->menu;
            $dishmenu = DishMenu::where('dish_id',$dishId)->where('menu_id',$menuid)->first();
            $price = isset($dishmenu)?$dishmenu->price:0;                                    
        }else{
            $price = $content['price'];
        }
        return $price;
    }

    public function receive_delete(order_delete $request)
    {
        $data_array = $request->all();
        $Order = OrderingNow::find($request->id);
        if(isset($Order))
        {
            $Order->status = -1;
            $Order->save();
            $dish_printer = $Order->dish->printer;
            $newPrintQueue = PrinterQueue::create(['printer' => $dish_printer, 'order_ids' => $data_array['id'], 'table_number' => $Order->table_number, 'status' => 0, 'type' => 2]);
            PrinterUpdate::create(['printer_que_id' => $newPrintQueue->id, 'attribute' => 'delete', 'new_value' => '1']);

        }
   }

    #TODO
    protected function InsertpreProcess(array &$data_array)
    {
    }
}
