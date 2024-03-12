<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Http\Requests\insert\settings_insert;
use App\Http\Requests\update\settings_update;

class SettingsC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new Settings;
    }
    
    public function receive_insert(settings_insert $request)
    {
        return $this->insert($request->all());
    }

    public function receive_update(settings_update $request)
    {
        return $this->update($request->all());
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
