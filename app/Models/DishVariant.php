<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishVariant extends GeneralModel{
    
    protected $table = 'dish_variant';
    protected $primaryKey ='name';
    public $incrementing = false;
    protected $fillable = ['name'];
    public $timestamps = false;
    
    public function get_key($id)
    {
        return $this->with(['variant.dish' => function($query){$query->where('status',0);}])->find($id);
    }

    public function get_all()
    {
        return $this->get();
    }

    public function variant()
    {
        return $this->hasMany(variant::class,'dish_variant_name');
    }

}