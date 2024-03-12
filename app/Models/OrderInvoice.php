<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInvoice extends GeneralModel{


    protected $table = 'order_invoice';
    protected $primaryKey ='id';

    protected $fillable = ['order_ids','value','old'];
    public $timestamps = false;

    public function ParseOrders($id_array)
    {
        $arraystring = '';
        foreach($id_array as $id)
        {
            $arraystring = $arraystring.$id.',';
        } 
        $arraystring = rtrim($arraystring,",");
        $this->order_ids = $arraystring;
    }

    public function get_key($id)
    {  
        
        $ret = $this->find($id);
        if (is_null($ret)) {
            return $ret;
        }
        $ret->GetOrders();
        
        return $ret;
    }

    public function GetOrders()
    {
        $order_ids_array = explode(",", $this->order_ids);
        if ($this->old == 0)
        {
            $orders = OrderingNow::with(['TableHistory','dish'])->whereIn('id',$order_ids_array)->get();
        }
        else{
            $orders = Ordering::whereIn('id',$order_ids_array)->get();
        }

        if ($orders->count() != count($order_ids_array)) {
            $this->warning = "some of the order are not found or not exists!";
        }

        $this->orders = $orders;
    }

}