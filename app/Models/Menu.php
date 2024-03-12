<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Menu extends GeneralModel{
     
    protected $table = 'menu';
    protected $primaryKey ='id';
    public $incrementing = false;
    protected $fillable = ['id','name','start_time','end_time','status','fixed_price'];
    public $timestamps = false;   

    public function IsDiscount(int $dish_id)
    {
        $menu = $this->dish_menu->where('dish_id',$dish_id)->first();
        if (isset($menu) && (isset($menu->start_discount) && isset($menu->end_discount))) 
        {   
            //dump($menu->start_discount);
            //dump($menu->end_discount);
            return Carbon::now()->between(Carbon::parse($menu->start_discount),Carbon::parse($menu->end_discount));
        }
        else
        {
            return false;
        }
        

    }

    public function GetAllWithDish($dishId)
    {
        $menus = $this->with(['dish_menu' => function($query) use ($dishId){$query->where('dish_id',$dishId);}])->get();
        $menus->each(function(&$item) use($dishId)
        {
            $item->discount = $this->IsDiscount($dishId);
        });
        return $menus;
    }

    public function dish_menu()
    {
        return $this->hasMany(DishMenu::class,'menu_id','id');
    }
    
    
}