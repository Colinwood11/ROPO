<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\user;
//use App\Http\Requests\insert\template_insert;

class UsersC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new user;
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
