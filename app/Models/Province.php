<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends GeneralModel{
    
    protected $table = 'province';
    protected $primaryKey ='id_province';
    public $incrementing = false;
    public $timestamps = false;
}