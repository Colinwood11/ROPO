<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function index(Request $request)
    {
        $data['tittle'] = __('messages.Home');
        $data['sidebar_active'] = 1;
        $data['fix_position_top'] = 1;
        $data['navbar_transparent'] = 1;


        return view('index', $data);
    }

}
