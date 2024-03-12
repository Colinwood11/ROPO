<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishMenu extends GeneralModel{
    
    protected $table = 'dish_menu';
    protected $primaryKey ='id';
    public $incrementing = false;
    protected $fillable = ['dish_id','menu_id','price','discounted_price','start_discount','end_discount','limit'];
    public $timestamps = false;

    public function get_key($id)
    {
        return $this->with(['dish'])->find($id);
    }

    public function deleteMenu($id)
    {
        $this->where('menu_id',$id)->delete();
    }

    public function Menu()
    {
        return $this->belongsTo (Menu::class,'menu_id','id');
    }

    public function Dish()
    {
        return $this->belongsTo(Dish::class,'dish_id','id');
    }
    
    
}