<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends GeneralModel{
    
    protected $table = 'category';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['Catname','weight'];
    public $timestamps = false;
    
    public function GetAllOnlyCat()
    {
        return $this->all();
    }

    public function get_all()
    {
        return $this->with(['subcategory' => function($query){$query->orderBy('weight','asc');}])->orderBy('weight')->get()->each(function(&$Category){
            $Category->subcategory->makehidden(['weight']);
        })->makehidden(['weight']);
    }


    public function SubCategory()
    {
        return $this->hasMany(SubCategory::class,'Category_id','id');
    }
}