<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends GeneralModel{
    
    protected $table = 'type';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['subcategory_id','dish_id'];
    public $timestamps = false;
    //public $hidden = ['dish'];
    
    public function dish()
    {
        return $this->belongsTo(dish::class,'dish_id');
    }

    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }

}