<?php

namespace App\Models;

use Carbon\Carbon;

class TableHistory extends GeneralModel{
    
    protected $table = 'table_history';
    protected $primaryKey ='id';
    public $incrementing = true;
    protected $fillable = [//'created_at',
    'table_id','start_time','table_discount', 'end_time','note','num_person','last_order','last_merge',/*'merge_lock','lock_time'*/];
    //?public $timestamps = true;
    protected $AUTO_UNLOCK_THRESHOLD = 3; //minutes

    public function checklock(){
        if($this->merge_lock == 1){
            $now = Carbon::now();
            if(isset($this->lock_time)){
                $locked_time = Carbon::parse($this->lock_time);
                if($now->subMinutes($this->AUTO_UNLOCK_THRESHOLD) > $locked_time){
                    $this->lock_time = null;
                    $this->merge_lock = 0; 
                    $this->save();
                }
            }
            else{//这个桌子被锁着，但是没有锁定时间，所以添加锁定时间
                $this->lock_time == $now;
                $this->save();
            }
        }
    }

    public function unlock_history(){
        $this->merge_lock = 0;
        $this->lock_time = null;
        $this->save();
    }

    public function lock_history(){
        $this->merge_lock = 1;
        $this->lock_time = Carbon::now();
        $this->save();
    }

    public function GetAllUnfinished(){   
        return $this->with(['OrderingNow.dish.dish_menu.menu','table'])->whereNull('end_time')->get();
    }

    //Printer cache and merge
    public function GetUnifishedWithOrder(){
        return $this->with(['OrderingNow'=>function($item){return $item->where('status','!=','-1');},'table','Orderque'])->whereNull('end_time')->get();
    }

    public function Ordering(){
        return $this->hasMany(Ordering::class,'table_history_id');
    }

    public function Orderque(){
        return $this->hasMany(OrderQue::class,'table_history_id');
    }

    public function OrderingNow(){
        return $this->hasMany(OrderingNow::class,'table_history_id');
    }

    public function Table(){
        return $this->belongsTo(Table::class,'table_id','id');
    }

}