<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NameLang extends GeneralModel{
    
    protected $table = 'namelang';
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $fillable = ['name'];
    public $timestamps = false;
    
    public function order_group()
    {
        return $this->hasMany(lang_var::class,'name','name');
    }
}