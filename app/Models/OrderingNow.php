<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class OrderingNow extends GeneralModel
{
    use HasFactory;

    protected $table = 'OrderingNow';
    protected $primaryKey = 'id';

    protected $fillable = ['table_history_id', 'price', 'menu', 'dish_id', 'status', 'user_id', 'order_at', 'number', 'que_number','note'];
    //public $timestamps = true;

    public function GetDetail($id)
    {
        return $this->with(['TableHistory.Table','dish'])->find($id);
    }

    public static function GetOrderTimes($tableHistory,$time)
    {
        $orders_intervals = self::where('table_history_id',$tableHistory)->where('order_at','>',$time)->get()->pluck('order_at')->unique();
        
        return $orders_intervals;
    }

    public static function GetWithMenu($id,$menu)
    {
        $order = self::with(['dish.dish_menu'=>function($query) use ($menu)
        {$query->where('menu_id',$menu);}])->where('id',$id)->first();
        
        return $order;
    }

    public function cash_order($id)
    {
        if (isset($id)) {
            $order = $this->find($id);
        }
        $id = $this->id;
        $input_array = $this->toArray();
        $variant = (new OrderVariant)->get_id($id);
        if (!is_null($variant)) {
            $input_array['variant'] = '';
            #unset($input_array['id']);
            $input_array['status'] = 'confirmed';

            foreach ($variant as $v) {
                $input_array['variant'] .= $v->dish_variant_name . ":" . $v->dose . ",";
            }
        }
        //create new at Ordering
        Ordering::create($input_array);
        //delete at OrderingNow
        (new OrderVariant)->DeleteOrderVariant($id);
        $this->delete();
    }

    public function ConfirmOrder($id, $number)
    {
        $order = $this->find($id);

        if ($order->que_number + $number >= $order->number) {
            $order->que_number = $order->number;
            $order->status = 'confirmed';
        } else {
            $order->que_number = $order->que_number + $number;
        }
        $order->save();
    }

    public static function MakeInvoiceOrder(&$order_data,$num_person,$OldtableHistory)
    {
        $NewTableHistory = false;
        $ids = array_column($order_data, 'id');
        $instances = self::with(['Dish'])->whereIn('id',$ids)->get();
        //$ids = $order_data->pluck('id');
        
        $OrderNow = OrderingNow::whereIn('id',$ids)->get()->keyBy('id');
        $OldtableHistory->num_person = $OldtableHistory->num_person-$num_person;
        
        if($OldtableHistory->num_person < 0){
            $OldtableHistory->num_person = 0;
        }


        $OldtableHistory->save();

        $NewHistoryArray = $OldtableHistory->toArray();
        $NewHistoryArray['num_person'] = $num_person;
        unset($NewHistoryArray['id']);//可能不需要

        $NewHistoryArray['end_time'] = Carbon::now();
        //这个新的history用来算账，和旧的history完全一样。
        $NewTableHistory = TableHistory::Create($NewHistoryArray);
        $invoice_orders = [];
        //思路：如果只要算一个订单的一部分数量，则创建一个新的订单，然后旧的订单减少一定的数量。
        //如果是全部算账则只需要把原来的Ordernow的Tablehistory改成新的要算账的即可。
        foreach($order_data as $order){

            //如果数量小于目前订单数量，则创建一个新的订单，用作算账的单。
            if(isset($order['number']) && $order['number'] < $OrderNow[$order['id']]->number){

                    $OrderNow[$order['id']]->number -= $order['number'];
                    $OrderNow[$order['id']]->save();

                    $NewOrder = $OrderNow[$order['id']]->toArray();
                    $NewOrder['number'] = $order['number'];
                    $NewOrder['table_history_id'] = $NewTableHistory->id;
                    unset($NewOrder['id']);//可能不需要
                    
                    if(isset($order['price'])){
                        $NewOrder['price'] = $order['price'];
                    }
                    
                    $addOrderId = OrderingNow::create($NewOrder)->id;
                     
            }else{
                //如果大于或者等于就把目前的单子的history加入到算账的单子里。
                $addOrderId = $order['id'];
                $OrderNow[$order['id']]->table_history_id = $NewTableHistory->id;

                if(isset($order['price'])){
                    $OrderNow[$order['id']]->price = $order['price'];
                }
                
            }
            $invoice_orders[] = $addOrderId;
            $OrderNow[$order['id']]->save();
        }
        return $invoice_orders;
        
    }

    public function GetWithHistory()
    {
        $tableHistory = new TableHistory;
        return $tableHistory->GetUnfinished();
    }

    public function GetUnfinished()
    {
        return $this->with(['dish', 'TableHistory.table'])->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function TableHistory()
    {
        return $this->belongsTo(TableHistory::class, 'table_history_id', 'id');
    }

    public function Dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id', 'id');
    }

    public function OrderVariant()
    {
        return $this->hasMany(OrderVariant::class, 'ordering_id', 'id');
    }
}
