<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintContent extends Model
{
    use HasFactory;
    protected $table = 'print_content';
    protected $primaryKey = null;

    protected $fillable = ['id','que_id','row','dish_id','number','print_menu_id','price'];
    public $timestamps = false;

    public static function GetContent(int $que_id,int $menu_id = null)
    {   
        if(isset($menu_id)){
            $order_array = self::where('que_id',$que_id)->where('print_menu_id',$menu_id)->get();
        }else{
            $order_array = self::where('que_id',$que_id)->get();
        }
        
        //因为需要获取【菜名】,所以需要这些出现的菜。
        $dish_ids = $order_array->pluck('dish_id');
        $dish_list = Dish::whereIn('id',$dish_ids)->get()->keyBy('id');

        $return_array = [];
        foreach ($order_array as $order){

            $tmp = collect([
                'name' => $dish_list[$order->dish_id]->name,
                'name_chn' => $dish_list[$order->dish_id]->name_chn,
                'number' => $order->number,
                'number_code' => $dish_list[$order->dish_id]->number_code,
            ]);
            $return_array[] = $tmp;
        }
        $return_collection = collect($return_array)->sortBy('number_code');
        
        return $return_collection;
    }

    public function InsertContent(int $que_id, array $order_array, /*int $type,*/ int $print_menu)
    {
        $data = [];
        foreach($order_array as $order);
        {
            $tmp = [];
            //$tmp['que_id'] = $que_id;//que id 其实不用？
            $tmp['dish_id'] = $order['dish_id'];
            $tmp['number'] = $order['number'];
            $tmp['print_menu_id'] = $print_menu;
            $tmp['price'] = $order['price'];
            $data[] = $tmp;
        }
        $this->create($data);
    }
}
