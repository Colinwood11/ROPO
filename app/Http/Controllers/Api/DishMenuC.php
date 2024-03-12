<?php

namespace App\Http\Controllers\Api;

use App\Models\DishMenu;

class DishMenuC extends ApiController
{
    public function __construct()
    {
        $this->_model = new DishMenu();
    }    
}
