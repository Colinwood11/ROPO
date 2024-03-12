<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Type;

use App\Http\Requests\insert\type_insert;


class TypeC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new Type;
    }

   //public function GetFreeTables()
   //{
   //    $tables = $this->_model->get_all();
   //    //$Table
   //    //$tables->filter(function($table){
   //    //    return $table->withcount(['table_history' => function($history){
   //    //        $history->whereNotNull('end_time');
   //    //    }])->where('table_history','>',1);
   //    //});
   //    return $tables->where('status','');
   //}


    public function receive_insert(type_insert $request)
    {
        return $this->insert($request->all());
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
