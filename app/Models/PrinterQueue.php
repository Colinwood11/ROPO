<?php

namespace App\Models;

use App\Models\PrinterUpdate;
use Illuminate\Database\Eloquent\Model;

class PrinterQueue extends GeneralModel{


    protected $table = 'printer_queue';
    protected $primaryKey ='id';

    protected $fillable = ['old', 'printer','order_ids','table_number','status','printed_at','fetched_at','note','created_at','type'];
    public $timestamps = false;

    public function RequestContent($id)
    {  
        
        $ret = $this->find($id);
        
        if (is_null($ret)) {
            return $ret;
        }
        $ret->empty = false;
        //$ret->GetOrders();
        
        return $ret;
    }

    public function GetUpdate()
    {
        return PrinterUpdateContent::where('que_id',$this->id)->get()->sortBy('row');
    }

    public function GetOrders()
    {
        $order_ids_array = explode(",", $this->order_ids);
        if ($this->old == 0)
        {
            #$this->type = "new mode";
            //new type: get first from the order now table if still empty get from the older table
            $orders = OrderingNow::with(['dish'])->whereIn('id',$order_ids_array)->get();
            #$orders = TableHistory::with(['dish','order_now.table'])->whereIn('id',$order_ids_array)->get();
            if ($orders->count() != count($order_ids_array)) {
                $orders = Ordering::whereIn('id',$order_ids_array)->get();
            }
            
        }
        else{#暂时没有old mode

            //$this->type = "old mode";
            //old type: only search from the old table
            $orders = Ordering::whereIn('id',$order_ids_array)->get();
        }

        if ($orders->count() != count($order_ids_array)) {
            if($orders->count() == 0)
            {
                return $this->empty = true;
            }
            $orders->warning = "some of the order are not found or not exists!";
        }


        $this->orders = $orders;
    }

    public function PrinterUpdate()
    {
        return $this->hasMany(PrinterUpdate::class,'printer_que_id');
    }

    public function OrderUpdate()
    {
        return $this->hasMany(OrderUpdate::class,'que_id');
    }

    public function PrintMenu()
    {
        return $this->hasMany(PrintMenu::class,'que_id');
    }

    public function PrintContent()
    {
        return $this->hasMany(PrintContent::class,'que_id');
    }

    public function PrintUpdateContent()
    {
        return $this->hasMany(PrinterUpdateContent::class,'que_id');
    }

}