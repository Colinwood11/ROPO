<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Variant;
use App\Http\Requests\insert\variant_insert;

class VariantC extends ApiController
{
    
    public function __construct()
    {
        $this->_model = new Variant;
    }
    
    public function receive_insert(variant_insert $request)
    {
        return $this->insert($request->all());
    }
}
