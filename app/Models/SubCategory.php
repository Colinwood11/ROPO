<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends GeneralModel{
    //
    protected $table = 'subcategory';
    protected $primaryKey ='id';
    public $incrementing = true;
    protected $fillable = ['name','Category_id','weight'];
    public $timestamps = false;
    
    public function GetAllWithCategory()
    {
        return $this->with(['Category'])->get();
    }

    public function GetAllWithDish()
    {
        return $this->with(['type.dish'])->get();
    }

    public function GetKeyWithDish($id)
    {
        return $this->with(['type.dish'])->find($id);
    }

    public function type()
    {
        return $this->hasMany(type::class,'subcategory_id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class,'Category_id');
    }

}