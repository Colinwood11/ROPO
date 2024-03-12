<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Ordering;
use Carbon\Carbon;
//use App\Models\Category;

use App\Http\Requests\insert\order_insert;
use App\Http\Requests\update\order_update;
use App\Http\Requests\delete\order_delete;

class OrderingC extends ApiController
{
    public function __construct()
    {
        $this->_model = new Ordering;
    }
   
    //public function get_insert(order_insert $request)
    //{
    //    //$array = $request->all();                 未测试
    //    return $this->insert($request->all());    //未测试，不知道能不能用
    //}

    //public function receive_insert(order_insert $request)
    //{
    //    $OrderArray = $request->all();                 //未测试
//
    //    foreach ($OrderArray as &$order) 
    //    {
    //        if (isset($order['code'])) 
    //        {
    //            unset($order['code']);
    //        }
//
    //        $order['user_id'] = isset($order['user_id'])? $order['user_id']:null;
    //        $order['table_history_id'] = isset($order['table_history_id'])? $order['table_history_id']:null;
    //        $order['created_at'] = Carbon::now();
    //        //$order['updated_at'] = Carbon::now();
    //        //ordering::create($order);
    //    }
    //    $this->_model->insert($OrderArray);
    //    return ['messagge'=>'insert success'];    //未测试，不知道能不能用
    //}

    protected function get_all_process(&$collection)
    {
        
    }


    protected function get_key_process(&$collection)
    {
        
    }

    protected function preProcess(array &$data_array)
    {
       
    }

    protected function postProcess(array &$data_array)
    {
       
    }
}
