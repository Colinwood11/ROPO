<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends GeneralModel{
    
    protected $table = 'faq';
    protected $primaryKey ='id';
    public $incrementing = false;
    protected $fillable = ['question','answer'];
    public $timestamps = false;
    
}