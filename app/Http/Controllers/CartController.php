<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\DishC;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function ViewCart(Request $request)
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['nullcart'] = 0;
        if (!isset($_COOKIE['cart']) || $_COOKIE['cart'] == "") {
            $data['nullcart'] = 1;
            return view('cart', $data);
        }

        $cart_data = json_decode($_COOKIE['cart'],true);
        unset($cart_data['row_number']);
        //dd($cart_data);
        if (count($cart_data) == 0) {
            $data['nullcart'] = 1;
            return view('cart', $data);
        }
        
        $cart_number_collect = collect($cart_data);
        $cart_ids = $cart_number_collect->pluck('dish_id');
        #dump($cart_ids);
        $dish_all = (new DishC)->GetAll()->whereIn('id', $cart_ids)->keyBy('id');
        $final_dish = array();

        foreach ($cart_data as $pos => $order_data) {
            $dish = $dish_all[$order_data['dish_id']];
            $final_dish[$pos]['dish_id'] =  $order_data['dish_id'];
            $final_dish[$pos]['name'] =  $dish['name'];
            $final_dish[$pos]['number'] = $order_data['number'];
            $menu = $dish->dish_menu->where('menu_id', $order_data['menu'])->first();
            $final_dish[$pos]['menu'] = $menu->Menu->name;
            $final_dish[$pos]['menu_id'] = $order_data['menu'];
            if ($dish->IsDiscount($order_data['menu'])) {
                $final_dish[$pos]['price'] = $menu->discounted_price;
            } else {
                $final_dish[$pos]['price'] = $menu->price;
            }
            if(isset($order_data['note']))
            {
                $final_dish[$pos]['key'] = 'note'.$pos+1;
            }
            else
            {
                $final_dish[$pos]['key'] = $order_data['dish_id'].$order_data['menu'];
            }
        }

        $data['dishs'] = $final_dish;
        return view('cart', $data);
    }
}
