<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableStatus extends GeneralModel
{
    use HasFactory;
    protected $table ='table_status';
    protected $fillable = ['id','meaning'];
    public $timestamps = false;
    public $incrementing = false;
}
