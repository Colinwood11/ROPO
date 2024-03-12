<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUpdate extends Model
{
    use HasFactory;
    protected $table = 'order_update';
    protected $primaryKey = 'id';

    protected $fillable = ['id','que_id','order_id','dish_id','table_history_id','type','number','note'];
    public $timestamps = false;

    public function UpdateOrder(int $que_id)
    {
        # code...
    }


    public function InsertUpdate(int $que_id, array $data)
    {
        # code...
    }

}
