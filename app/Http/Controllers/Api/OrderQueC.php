<?php

namespace App\Http\Controllers\Api;
use App\Models\OrderQue;


use App\Http\Requests\update\orderque_update;
use App\Http\Requests\delete\orderque_delete;

class OrderQueC extends ApiController
{
    public function __construct()
    {
        $this->_model = new OrderQue();
    }


    public function ReceiveUpdate(orderque_update $request)
    {
        //TODO:Preprocess for variant
        $data = $request->all();
        $history = OrderQue::find($data['updatelist'][0]['id'])->TableHistory;

        foreach($data['updatelist'] as &$order){
            $id = $order['id'];
            unset($order['id']);
            if(isset($order['number'])&& $order['number'] ==0){
                OrderQue::fin($id)->delete();
                continue;
            }
            
            if(isset($order['menu']) && isset($order['price']) == false)
            {
                $order['price'] = OrderQue::GetWithMenu($order['id'],$order['menu'])->dish->dish_menu[0]->price;
            }
            
            OrderQue::where('id',$id)->update($order);
        }
        $history->unlock_history();
        return response(['message'=> 'update success'],200);
    }

    public function ReceiveDelete(orderque_delete $request)
    {
        $printercache = $this->_model->find($request->id)->PrinterCache;
        
        $this->delete($request->all());
        if(count($printercache->Orderque) == 0)
        {
            $printercache->delete();
        }
        return 0;
    }
    

    
}
