<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrinterList extends GeneralModel{
    
    protected $table = 'printer_list';
    protected $primaryKey ='id';
    public $incrementing = false;

    protected $fillable = ['id', 'name'];
    public $timestamps = false;

}