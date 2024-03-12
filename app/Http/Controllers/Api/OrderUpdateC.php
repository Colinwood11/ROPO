<?php

namespace App\Http\Controllers\Api;

use App\Models\PrinterUpdate;
use Illuminate\Http\Request;

class OrderUpdateC extends ApiController
{
    public function __construct()
    {
        $this->_model = new PrinterUpdate;
    }
}
