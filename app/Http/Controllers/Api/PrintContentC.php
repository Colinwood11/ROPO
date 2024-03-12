<?php

namespace App\Http\Controllers\Api;

use App\Models\PrintContent;
use Illuminate\Http\Request;

class PrintContentC extends ApiController
{
    public function __construct()
    {
        $this->_model = new PrintContent;
    }
}
