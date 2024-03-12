<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Api\DishC;
use App\Http\Controllers\Api\MenuC;
use App\Http\Controllers\Api\OrderNowC;
use App\Models\Table;
use TableHistory;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['cats'] = (new Category)->get_all()->toarray();
        $data['menu_list'] = (new MenuC)->GetAll();
        return view('order', $data);
    }


    public function OrderListView()
    {
        
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['nullorders'] = 0;
        if (!isset($_COOKIE['code']) || $_COOKIE['code'] == "") {
            $data['nullorders'] = 1;
            return view('orderlist', $data);
        }

        $cart_data = (new Table)->getUnfinished($_COOKIE['code']);
        $cart_data_que = (new Table)->getUnfinishedQueue($_COOKIE['code']);
        
        if (!isset($cart_data) && !isset($cart_data_que)) {
            $data['nullorders'] = 1;
            return view('orderlist', $data);
        }

        $cart_data = $cart_data->toArray();
        $cart_data_que = $cart_data_que->toArray();
        
        $cart_data_que = array_values(array_filter($cart_data_que['table_history'], function($v) {
            return $v['end_time'] == null;
        }));
        $cart_data = array_values(array_filter($cart_data['table_history'], function($v) {
            return $v['end_time'] == null;
        }));

        if(!isset($cart_data)  && !isset($cart_data_que))
        {
            $data['empty'] = 1;
            return view('orderlist', $data);
        }
        $cart_data = $cart_data[0]['ordering_now'];
        
        $cart_data_que = $cart_data_que[0]['orderque'];
        
        $final_dish = array();
        //dd($cart_data);
        $MenuList = (new MenuC)->GetAll()->keyBy('id')->toArray();
        foreach ($cart_data as $pos => $order) {
            //dd($order);
            $final_dish[$pos]['order_id'] =  $order['id'];
            $final_dish[$pos]['name'] =  $order['dish']['name'];
            $final_dish[$pos]['number'] = $order['number'];
            $menu = $MenuList[$order['menu']];
            $final_dish[$pos]['menu'] = $menu['name'];
            $final_dish[$pos]['que_number'] = $order['que_number'];
            $price = 0;

            $final_dish[$pos]['price'] = $price;
        }
        
        $data['dishs'] = $final_dish;

        $final_dish = array();
        foreach ($cart_data_que as $pos => $order) {
            //dd($order);
            $final_dish[$pos]['order_id'] =  $order['id'];
            $final_dish[$pos]['name'] =  $order['dish']['name'];
            $final_dish[$pos]['number'] = $order['number'];
            $menu = $MenuList[$order['menu']];
            $final_dish[$pos]['menu'] = $menu['name'];
            $price = 0;

            $final_dish[$pos]['price'] = $price;
        }


        
        $data['orderque'] = $final_dish;
        return view('orderlist', $data);
    }
    
}
