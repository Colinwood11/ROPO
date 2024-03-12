<?php

namespace App\Http\Controllers\Api;

use App\Models\SubCategory;
use App\Models\Type;
use App\Http\Requests\insert\SubCategory_insert;
use App\Http\Requests\update\SubCategory_update;
use App\Http\Requests\delete\SubCategory_delete;

class SubCategoryC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new SubCategory;
    }
    
    public function receive_insert(SubCategory_insert $request)
    {
        $data_array = $request->all();       
        $model = $this->_model;
        
        $new = $model->create($data_array)->id;
        $message = ['messagge'=>'insert success','id'=>$new];
        return response($message,201);
    }

    public function receive_update(SubCategory_update $request)
    {
        return $this->update($request->all());
    }

    protected function DeletepreProcess(array &$data_array)
    {
        Type::where('subcategory_id',$data_array['id'])->delete();
    }

    public function receive_delete(SubCategory_delete $request)
    {
        return $this->delete($request->all());
    }

    protected function get_all_process(&$collection)
    {
        
    }

    public function GetAllWithDish()
    {
        $response = $this->_model->GetAllWithDish();

        return $response;
    }

    public function GetAllWithCategory()
    {
        $response = $this->_model->GetAllWithCategory();
        return $response;
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
