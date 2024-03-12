<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Province;
//use App\Http\Requests\insert\template_insert;

class ProvinceC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new Province;
    }
    
    public function get_insert(Request $request)
    {
        
    }


}
