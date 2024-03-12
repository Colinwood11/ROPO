<?php

namespace App\Http\Controllers\Api;

use App\Models\NameLang;
use App\Http\Requests\insert\namelang_insert;

class NameLangC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new NameLang;
    }
    
    public function receive_insert(namelang_insert $request)
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
