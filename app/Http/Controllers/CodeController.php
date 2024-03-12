<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Api\MenuC;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    
    public function ViewCode()
    {
        $data['tittle'] = __('messages.Code');
        $data['sidebar_active'] = 2;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 0;
        $data['MenuList'] = (new MenuC)->GetAll()->keyBy('id')->toArray();
        return view('code',$data);
    }
}
