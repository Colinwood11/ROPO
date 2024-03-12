<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    protected $_model;

    protected function get_all_process(&$collection)
    {

    }

    protected function get_key_process(&$collection)
    {

    }

    //protected function test_locale(Request $req)//鸽
    //{
//
    //    $language = $req->getPreferredLanguage();//('HTTP_ACCEPT_LANGUAGE');//App::currentLocale();
    //    return $language;
    //}

    public function GetAll(){
        $response = $this->_model->get_all();
        if (isset($response)) {
            $this->get_all_process($response);
        }
        return $response;
    }

    public function GetKey($key){ 
        $response = $this->_model->get_Key($key);
        if (isset($response)) {
            $this->get_key_process($response);
        }        
        return $response;
    }

    public function GetSelf(Request $request){
        if (null !== $request->user() ) 
        {
            $response = $this->_model->get_self($request->user()->id);
            return $response;
        }
        else
        {
            return null;
        }
           
       
    }

    public function insert(array $data,array $message = null,bool $preProcess = true, bool $postProcess = true)
    {
        $data_array = $data;
        if ($preProcess) {$this->InsertpreProcess($data_array);}        
        $save = isset($save)? $save:true;
        $model = $this->_model;
        $message = isset($message)?$message:['messagge'=>'insert success'];

        $model->fill($data_array)->save();
        if ($postProcess) {$this->InsertpostProcess($data);}
        return response($message,201);
    }


    public function update(array $data,array $message = null,bool $preProcess = true, bool $postProcess = true)
    {
        $data_array = $data;
        if ($preProcess) {$this->UpdatepreProcess($data_array);}
        $model = $this->_model;
        $message = isset($message)?$message:['messagge'=>'update success'];
        
        //get key
        $primary_keys = $model->getkeyname();
        //return($data_array[$primary_keys]);

        $primary_arrays = array();
        if (is_array($primary_keys))
        {

            foreach($primary_keys as $key)
            {
                $primary_arrays[$key] = $data_array[$key];
                unset($data_array[$key]);
            } 
        }
        else
        {   $primary_arrays[$primary_keys] = $data_array[$primary_keys];
            unset($data_array[$primary_keys]);
        }
              
        
        $model = $model->where($primary_arrays)->update($data_array);
        //return $model;
        //$model->fill($data_array)->save();
        if ($postProcess) {$this->UpdatePostProcess($data);}
        return response($message,201);
    }

    public function delete(array $data,array $message = null,bool $preProcess = true, bool $postProcess = true,bool $foreign = false)
    {
        if ($foreign == false) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }
        
        $data_array = $data;
        if ($preProcess) {$this->DeletePreProcess($data_array);}
        
        $model = $this->_model;
        $message = isset($message)?$message:['messagge'=>'delete success'];
                //get key
        $primary_keys = $model->getkeyname();
        //return($data_array[$primary_keys]);

        $primary_arrays = array();
        if (is_array($primary_keys))
        {

            foreach($primary_keys as $key)
            {
                $primary_arrays[$key] = $data_array[$key];
                unset($data_array[$key]);
            } 
        }
        else
        {   $primary_arrays[$primary_keys] = $data_array[$primary_keys];
            unset($data_array[$primary_keys]);
        }
        
        $model = $model->where($primary_arrays)->delete($data_array);
        if ($postProcess) {$this->DeletePostProcess($data);}
        
        if ($foreign == false) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
        
        return response($message,201);
    }


    protected function InsertpreProcess(array &$data_array)
    {
       
    }
    protected function UpdatepreProcess(array &$data_array)
    {
       
    }
    protected function DeletepreProcess(array &$data_array)
    {
       
    }

    protected function InsertpostProcess(array &$data_array)
    {
       
    }

    protected function UpdatepostProcess(array &$data_array)
    {
       
    }

    protected function DeletepostProcess(array &$data_array)
    {
       
    }
}
