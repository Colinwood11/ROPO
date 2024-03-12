<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\insert\printer_insert;
use App\Http\Requests\printer_confirm;
use App\Models\Dish;
use App\Models\Menu;
use App\Models\PrinterQueue;
use App\Models\OrderingNow;
use Carbon\Carbon;
use App\Models\Ordering;
use App\Models\OrderInvoice;
use App\Models\PrintContent;
use App\Models\PrintMenu;
use App\Models\Settings;
use App\Models\TableHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class PrinterQueueC extends ApiController
{
    //requested :dishname,ordertime,table number,mode
    public function __construct()
    {
        $this->_model = new PrinterQueue;
    }

    public function receive_insert(printer_insert $request)
    {
        return $this->insert($request->all());
    }


    public function PrintFinish(printer_confirm $request, $debug = null)
    {
        $EXCLUDE_ATTRIBS = ['table_add', 'table_delete', 'printer_wait'];
        #测试的时候关闭
        if (isset($debug)) {
            $this->_model = PrinterQueue::find($debug);
        } else {
            $this->_model = PrinterQueue::find($request->id);
        }

        $this->_model->status = 2;
        $this->_model->printed_at = Carbon::now();
        #因为时间关系，暂时没有oldmode
        #$this->_model->old = 1;

        $this->_model->save();
        //3号模式：修改订单
        #前置条件：修改的是【单个】order
        switch ($this->_model->type) {
            //0号模式，点菜
            //2和3都是和修改订单有关系的
            //啥都不干，因为已经在输入的时候搞定了。
            case 0:
            case 2:
            case 3:
                
            break;
            #结账点单，需要把原来的订单丢进"垃圾桶"里。
            case 1: {
                    $print_model = $this->_model->find($request->id);
                    $invoice = (new OrderInvoiceC)->GetKey($print_model->order_ids);

                    $orders_array = $invoice->orders->toArray();
                    #改成单个SQL指令
                    $orders_ids = $invoice->orders->pluck('id');
                    foreach($orders_array as &$order){
                        unset($order['dish']);//这个是relationship
                        unset($order['id']);
                        unset($order['total_price']);
                        unset($order['table_history']);//这个是relationship
                        $order['created_at'] = str_replace('T',' ',$order['created_at']);
                        $order['created_at'] = str_replace('Z',' ',$order['created_at']);
                        $order['updated_at'] = str_replace('T',' ',$order['updated_at']);
                        $order['updated_at'] = str_replace('Z',' ',$order['updated_at']);
                    }                    
                    $increment_before = 0;
                    $increment_after = 0;
                    //因为是transaction，所以需要获取increment的数值。
                    $sql_str1 = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".env("DB_DATABASE")."' AND TABLE_NAME = 'ordering'";
                    $sql_str2 = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".env("DB_DATABASE")."' AND TABLE_NAME = 'ordering'";
                    //因为在输入多行的情况下的情况下没有办法即使用一个query同时获取所有的id，所以使用自增值来获取所有id。
                    //由于是transaction，所以在这期间不会有其他的输入此表的线程干扰这个数值。
                    DB::transaction(function() use ($orders_array,$sql_str1,$sql_str2,&$increment_before,&$increment_after){
                        // 1- get the last id of your table
                        $increment_before =  DB::select($sql_str1)[0]->AUTO_INCREMENT;
                        // 2- insert your data
                        Ordering::insert($orders_array);
                        // 3- Getting the last inserted ids
                        $increment_after =  DB::select($sql_str2)[0]->AUTO_INCREMENT;                   
                    });
                    $TableHistory_id = OrderingNow::whereIn('id',$orders_ids)->first()->table_history_id;
                    $TableHistory = TableHistory::with(['OrderingNow','Table'])->find($TableHistory_id);
                    Log::info('history at finish');
                    Log::info($TableHistory);

                    OrderingNow::whereIn('id',$orders_ids)->delete();
                    $order_ids = '';
                    for($i = $increment_before;$i<$increment_after;$i++)
                    {
                        $order_ids = $order_ids.$i.',';
                    }
                    $order_ids = rtrim($order_ids,",");
                    OrderInvoice::find($print_model->order_ids)->update(['order_ids'=>$order_ids,'old'=>1]);
                    
                    $ActualHistory = $TableHistory->Table->GetThisUnfinishedHistory();

                    Log::info('Actual history at finish');
                    Log::info($ActualHistory);

                    #History和table确认，修改检查剩余订单数量和未算账桌子人数。如果已经清理了则关闭桌子。
                    if($ActualHistory->num_person <= 0 && count($ActualHistory->OrderingNow) == 0){
                        $table = $ActualHistory->table;
                        if (isset($table)) {
                            $table->Deactivate();
                        }
                    }
                }
                break;
            default:
                Log::info('default finish.');
            break;
        }

        return response(['confirmation' => 'success'], 200);
    }

    public function GetPrintQueue()
    {   
        $cachemodel = (new PrinterCacheC);
        $cachemodel->CheckMerge();
        $this->CheckStuckedList();
        $QueueList = $this->_model->where('status', 0)->select('id', 'printer')->get();
        $this->_model->where('status', 0)->select('id', 'printer')->update(['status' => 1,'fetched_at' => Carbon::now()]);
        return $QueueList;
    }

    protected function CheckStuckedList()
    {
        $reset_threshold = 2; //minutes
        $QueueList = $this->_model->where('status', 1)->get();
        $minutes_ago = Carbon::now()->subMinutes($reset_threshold);
        foreach($QueueList as $print_elem)
        {
            if($minutes_ago->gt(Carbon::parse($print_elem->fetched_at)))
            {
                $print_elem->status = 0;
                $print_elem->save();
            }
        }
    }

    protected function ParseKitchen($print_order)
    {

        #group by menus
        $menus = PrintMenu::GetMenuWithContent($print_order->id);

        $print_order->orders = PrintContent::GetContent($print_order->id);
        $print_order->menus = $menus;
        $print_order->total = $print_order->orders->sum('number');
        $print_order->created_at = Carbon::parse($print_order->created_at)->format('m-d H:i:s');
        $print_order->num_person = $menus[0]->number_person;
        $print_order->rowNumber = count($print_order->orders) + 5;
        return $print_order;
    }

    public function ParseCheckout($print_order)
    {
        $invoice = (new OrderInvoiceC)->GetKey($print_order->order_ids);
        $invoice->rowNumber = count($invoice->orders) + 10;
        return $invoice;
    }

    //Constraint: only 1 order update at a time
    protected function ParseUpdate(PrinterQueue $print_order)
    {

        $update_raw = $print_order->getUpdate();
        $update_grouped = [];
        foreach($update_raw as &$update){
            $key = $update['dish_name'];
            if(!isset($update_grouped[$key])){
                $update_grouped[$key] = [];
                $update_grouped[$key]['dish_name'] = $update['dish_name'];
                $update_grouped[$key]['dish_name_chn'] = $update['dish_name_chn'];
                $update_grouped[$key]['original_number'] = $update['original_number'];
            }
            unset($update['dish_name']);
            unset($update['dish_name_chn']);
            unset($update['original_number']);
            $update_grouped[$key]['content'][] = $update;
        }
        $print_order->update = $update_grouped;
        $print_order->created_at = Carbon::parse($print_order->created_at)->format('m-d H:i:s');
        //dd($print_order);
        return $print_order;
    }

    //request from the printer middleware
    public function PrintRequest(int $id)
    {
        $print_order = $this->_model->RequestContent($id);
        $settings = Settings::all()->keyBy('name');
        $data['settings'] = $settings;
        if ($print_order === null) {
            return response(['messagge' => 'not found'], 404);
        }


        switch ($print_order->type) {
            case 0: //kitchen type
                if($print_order->empty != true)
                {
                    $print_order = $this->ParseKitchen($print_order);
                    $data['print_order'] = $print_order;
                    //$pdf = PDF::loadView('printer.kitchen', $data)->setPaper(array(0, 0, 210, 1500), 'portrait');
                    //return view('printer.kitchen', $data);
                    $pdf = PDF::loadView('printer.kitchen', $data);
                    return $pdf->download($id . '.pdf');
                }
                else
                {
                    $print_order->delete();
                    return response(['messagge' => 'print list has no order'], 404);;
                }//
                break;
            case 1: // checkout type
                $print_order = $this->ParseCheckout($print_order);
                $data['print_order'] = $print_order;
                //$pdf = PDF::loadView('printer.checkout', $data)->setPaper(array(0, 0, 210, 1500), 'portrait');
                $pdf = PDF::loadView('printer.checkout', $data);
                return $pdf->download($id . '.pdf');
                break;
            case 2: //update order type
                $print_order = $this->ParseUpdate($print_order);
                $data['print_order'] = $print_order;
                //return view('printer.update', $data);
                
                //$pdf = PDF::loadView('printer.update', $data)->setPaper(array(0, 0, 210, 1500), 'portrait');
                $pdf = PDF::loadView('printer.update', $data);
                return $pdf->download($id . '.pdf');
                break;
            default: // error type not defined
                $data['print_order'] = $print_order;
                return response('undefined type', 400);
                break;
        }
    }
}
