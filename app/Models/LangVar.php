<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LangVar extends GeneralModel{
    
    protected $table = 'langvar';
    protected $primaryKey = ['name','lang'];
    public $incrementing = false;
    protected $fillable = ['name','lang','value'];
    public $timestamps = false;

}