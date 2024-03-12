<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\template_model;
//use App\Http\Requests\insert\template_insert;

class dup_template extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new template_model;
    }
    
    public function get_insert(Request $request)
    {
        
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
