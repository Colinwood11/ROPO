<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Table extends GeneralModel{

    protected $table = 'table_res';
    protected $primaryKey ='id';
    public $incrementing = true;
    protected $fillable = ['status', 'code','number','num_person','menu'];
    public $timestamps = false;

    public function Activate($code_power = 4)
    {
        $this->code = substr(str_shuffle(str_repeat("0123456789",$code_power)), 0, $code_power);
        //$this->code = $this->number;
        $this->status = '1';
        $this->save();
        return $this->code;
    }

    public function Deactivate()
    {
        $this->code = NULL;
        $this->status = '0';
        $this->menu_id = NULL;
        TableHistory::where('table_id',$this->id)->whereNull('end_time')->update(['end_time'=>Carbon::now()]);
        $this->save();
    }

    public function GetThisUnfinishedHistory()
    {
        return TableHistory::with(['OrderingNow'])->wherenull('end_time')->where('table_id',$this->id)->first();
    }

    public function GetWithUnfinishedHistory($id)
    {
        return $this->with(['TableHistory'=>function($history)
        {
            return $history->with(['OrderingNow'=>function($query)
            {return $query->with(['Dish'])->where('status','!=','-1');}])->wherenull('end_time');
        }])->find($id);
    }

    public function GetWithUnfinishedHistoryNotPrinted($id)
    {
        return $this->with(['TableHistory'=>function($history)
        {
            return $history->with('Orderque.Dish')->wherenull('end_time');
        }])->find($id);
    }

    public function getByCode($code)
    {
        return $this->where('code',$code)->where('status',1)->first();
    }

    public function getUnfinished($code)
    {
        return $this->with(['TableHistory.OrderingNow'=>
        function($query){
            return $query->with(['Dish.dish_menu.Menu'])->where('status','!=','-1');
        }])->where('code',$code)->first();
    }

    public function getUnfinishedQueue($code)
    {
        return $this->with(['TableHistory.Orderque.Dish.dish_menu.Menu'])->where('code',$code)->first();
    }

    public function get_key($id)
    {
        return $this->with(['TableHistory'])->find($id);
    }

    public function GetAllUnfinished()
    {
        return $this->with(['TableHistory'=>function($history)
        {
            return $history->wherenull('end_time');
        }])->get();
    }

    public function get_all()
    {
        return $this->with(['TableHistory'])->get();
    }

    public function TableHistory()
    {
        return $this->hasMany(TableHistory::class,'table_id');
    }

}
