<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordering extends GeneralModel{


    protected $table = 'ordering';
    protected $primaryKey ='id';

    protected $fillable = ['id','table_history_id', 'price','mode','dish_id','variant','status','user_id','order_at','variant','menu','que_number','note'];
    //public $timestamps = true;

    public function get_all()
    {
        return $this->with(['Dish','TableHistory'])->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function TableHistory()
    {
        return $this->belongsTo(TableHistory::class,'table_history_id','id');
    }

    public function Dish()
    {
        return $this->belongsTo(Dish::class,'dish_id','id');
    }
}