<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends GeneralModel{
    
    protected $table = 'variant';    
    protected $fillable = ['dish_id','dish_variant_name'];
    public $timestamps = false;
    //protected $primaryKey =['dish','variant'];    
    //protected $primaryKey = ['dish_id','dish_variant_name'];
    public $increment = false;

    public function dish()
    {
        return $this->BelongsTo(dish::class,'dish_id');
    }

    public function dish_variant()
    {
        return $this->BelongsTo(dish_variant::class,'dish_variant_name');
    }

}