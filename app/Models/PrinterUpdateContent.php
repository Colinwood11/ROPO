<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterUpdateContent extends Model
{
    use HasFactory;
    protected $table = 'print_update_content';
    protected $primaryKey ='id';

    protected $fillable = ['que_id','original_number','attribute','dish_name','dish_name_chn','original_value','original_value_chn','target_value','target_value_chn','row','type'];
    public $timestamps = false;
}
