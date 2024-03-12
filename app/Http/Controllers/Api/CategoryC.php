<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Requests\insert\Category_insert;
use App\Http\Requests\update\Category_update;
use App\Http\Requests\delete\Category_delete;
use App\Models\SubCategory;
use App\Models\Type;

class CategoryC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new Category;
    }

    public function GetAllOnlyCat()
    {
        return $this->_model->GetAllOnlyCat();
    }

    public function receive_insert(Category_insert $request)
    {
        return $this->insert($request->all());
    }

    public function receive_update(Category_update $request)
    {
       return $this->update($request->all());
    }

    public function receive_delete(Category_delete $request)
    {
       return $this->delete($request->all());
    }

    protected function DeletepreProcess(array &$data_array)
    {
        $cat = $this->_model->find($data_array['id']);
        $subids = SubCategory::where('category_id',$data_array['id'])->pluck('id');
        Type::whereIn('subcategory_id',$subids)->delete();
        SubCategory::where('category_id',$data_array['id'])->delete();       
    }

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
