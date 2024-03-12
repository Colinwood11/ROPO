<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderQue extends GeneralModel
{
    use HasFactory;

    protected $table = 'Orderque';
    protected $primaryKey ='id';

    protected $fillable = ['id','order_at','price','menu','number','dish_id','user_id','table_history_id','cache_id'];
    public $timestamps = false;
    
    public static function MoveToOrderNow(int $id)
    {
        $model = self::find($id);
        $model_array = $model->toArray();
        unset($model['cache_id']);
        unset($model['id']);
        $new_id = OrderingNow::create($model_array)->id;
        return $new_id;
    }

    public static function GetWithMenu($id,$menu)
    {
        $order = self::with(['dish.dish_menu'=>function($query) use ($menu)
        {$query->where('menu_id',$menu);}])->where('id',$id)->first();
        
        return $order;
    }

    public static function GetWithHistory($id)
    {
        return self::with(['TableHistory'])->find($id);
    }

    public function GetNoHistory()
    {        
        return $this->whereNull('table_history_id')->get();
    }

    public function PrinterCache()
    {
        return $this->belongsTo(PrinterCache::class,'cache_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function TableHistory()
    {
        return $this->belongsTo(TableHistory::class,'table_history_id','id');
    }

    public function Dish()
    {
        return $this->belongsTo(Dish::class,'dish_id','id');
    }
}
