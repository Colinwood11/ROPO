<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\DishC;

class DishController extends Controller
{
    public function View_Detail($id)
    {
        $data['tittle'] = __('messages.Order');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['dish'] = (new DishC)->GetKey($id)->toArray();
        return view('dish_detail', $data);
    }

}
