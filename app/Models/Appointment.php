<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends GeneralModel
{
    use HasFactory;

    protected $table = 'appointment';
    protected $primaryKey ='id';

    protected $fillable = ['time', 'user_id','number_person','notes'];
    public $timestamps = false;
    public $hidden = ['created_at','updated_at'];
}
