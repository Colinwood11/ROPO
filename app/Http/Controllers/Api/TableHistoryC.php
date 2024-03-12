<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TableHistory;
use App\Http\Requests\insert\table_history_insert;
use App\Http\Requests\update\table_history_update;
use App\Http\Requests\table_history_lock;
use Carbon\Carbon;

class TableHistoryC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new TableHistory;
    }
    
    public function lock_history(table_history_lock $request)
    {
        $history = $this->_model->find($request->id);
        $history->lock_history();
    }

    public function unlock_history(table_history_lock $request)
    {
        $history = $this->_model->find($request->id);
        $history->unlock_history();
    }

    public function receive_insert(table_history_insert $request)
    {
        return $this->insert($request->all());
    }


    public function receive_update(table_history_update $request)
    {
        return $this->update($request->all());
    }

    public function getOrders($id)
    {
        return $this->orders();
    }

    public function GetAllUnfinished()
    {   
        
        $tableHistory = $this->_model->GetAllUnfinished();

        return $tableHistory;
    }

    protected function get_all_process(&$collection)
    {
        
    }

    protected function InsertpreProcess(array &$data_array)
    {
       $data_array['start_time'] = Carbon::now();
    }

    protected function get_key_process(&$collection)
    {
        
    }

}
