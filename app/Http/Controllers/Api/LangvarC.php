<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\langvar;
use App\Http\Requests\insert\langvar_insert;

class langvarC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new langvar;
    }
    
    public function receive_insert(langvar_insert $request)
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
