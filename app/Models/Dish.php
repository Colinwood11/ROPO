<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Type;

class Dish extends GeneralModel{
    
    protected $table = 'dish';
    protected $primaryKey ='id';

    protected $fillable = ['img', 'name','name_chn','description','status','printer','number_code','code'];
    public $timestamps = false;
    public $hidden = ['created_at','updated_at'];

    

    public function IsDiscount(int $menu_id)
    {
        $menu = $this->dish_menu->where('menu_id',$menu_id)->first();
        if (isset($menu) && (isset($menu->start_discount) && isset($menu->start_discount))) 
        {
            return Carbon::now()->between(Carbon::parse($menu->start_discount),Carbon::parse($menu->end_discount));
        }
        else
        {
            return false;
        }
        

    }

    public function get_key($id)
    {
        $response = $this->with(['variant','type.subcategory','dish_menu.Menu'])->where('status',0)->find($id);
        $response->dish_menu->each(function(&$elem)
        {
            $elem->discount = $this->IsDiscount($elem->menu_id);
        });
        return $response;
    }

    public function get_all()
    {
        return $this->with(['type.subcategory','dish_menu.Menu'])->where('status',0)->get();
    }

    public function Get_filtered($menu_id,array $types)
    {
        $num = count($types);
        $result = Type::with(['dish'=>
        function($query)use($menu_id)
        {
            $query
            ->with(['dish_menu'=>function($query)use ($menu_id){$query->where('menu_id',$menu_id);}])
            ->select(['id','name','number_code','img','code'])
            ->where('status',0)
            ->withcount(['dish_menu'=>function($query)use ($menu_id){$query->where('menu_id',$menu_id);}])
            ->having('dish_menu_count','=','1');
        }])
        ->select('dish_id')
        ->selectraw("COUNT('subcategory_id') as type_number")
        ->whereIn('subcategory_id',$types)
        ->groupBy('dish_id')
        ->havingRaw("type_number=".$num)
        ->get();

        $result = collect($result->pluck(['dish']))->sortBy('name');
        $result = $result->filter(function($item){return isset($item);})->values();
        if(count($result)>0)
        {   
            
            $result->each(function(&$item){
                
                $item->price = $item->dish_menu[0]->price;
                $item->menu_id = $item->dish_menu[0]->menu_id;
                $item->start_discount = $item->dish_menu[0]->start_discount;
                $item->end_discount = $item->dish_menu[0]->end_discount;
                $item->limit = $item->dish_menu[0]->limit;
                $item->makehidden(['dish_menu_count']);
                $item->makehidden(['dish_menu']);
            }
            );
        }
        $result = collect($result)->sortBy('name')->toArray();
        return $result;
    }
    //
    public function GetAllMenu($menu_id)
    {
        $result = $this->with(['dish_menu'=>function($dish_menu) use ($menu_id){$dish_menu->where('menu_id',$menu_id);}])
        ->select(['id','name','number_code','img','code'])
        ->withcount(['dish_menu'=>function($query)use ($menu_id){$query->where('menu_id',$menu_id);}])
        ->where('status',0)
        ->having('dish_menu_count','=','1')
        ->OrderBy('name')
        ->get();
        if(count($result)>0)
        {
            $result->each(function(&$item){
                $item->price = $item->dish_menu[0]->price;
                $item->menu_id = $item->dish_menu[0]->menu_id;
                $item->start_discount = $item->dish_menu[0]->start_discount;
                $item->end_discount = $item->dish_menu[0]->end_discount;
                $item->limit = $item->dish_menu[0]->limit;
                $item->makehidden(['dish_menu','dish_menu_count']);
            });
        }
        return $result;
    }

    public function DeleteRelationship()
    {
        type::where('dish_id',$this->id)->delete();
        DishMenu::where('dish_id',$this->id)->delete();
        Variant::where('dish_id',$this->id)->delete();
    }

    public function ordering()
    {
        return $this->hasMany(Ordering::class,'dish_id');
    }

    public function orderingnow()
    {
        return $this->hasMany(OrderingNow::class,'dish_id');
    }

    public function variant()
    {
        return $this->hasMany(variant::class,'dish_id');
    }

    public function type()
    {
        return $this->hasMany(type::class,'dish_id');
    }

    public function dish_menu()
    {
        return $this->hasMany(DishMenu::class,'dish_id');
    }
    
}