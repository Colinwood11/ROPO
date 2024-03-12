<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrinterUpdate extends GeneralModel{


    protected $table = 'printer_update';
    protected $primaryKey ='id';

    protected $fillable = ['printer_que_id','attribute','new_value'];
    public $timestamps = false;


}