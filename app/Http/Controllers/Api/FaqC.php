<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\faq;
use App\Http\Requests\insert\faq_insert;

class FaqC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new faq;
    }
    
    public function receive_insert(faq_insert $request)
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
