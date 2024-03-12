<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderVariant extends GeneralModel{


    protected $table = 'ordervariant';
    protected $primaryKey = null;

    protected $fillable = ['ordering_id','dish_variant_name','dose'];
    public $timestamps = false;

    public function get_id($id)
    {
       return $this->where('ordering_id',$id)->get();
    }

    public function DeleteOrderVariant($IdOrder)
    {
        $this->where('ordering_id',$IdOrder)->delete();
    }

    public function ordering()
    {
        return $this->belongsTo(ordering::class,'ordering_id','id');
    }

    public function dish_variant()
    {
        return $this->belognsTo(dish_variant::class,'dish_variant_name','name');
    }
}