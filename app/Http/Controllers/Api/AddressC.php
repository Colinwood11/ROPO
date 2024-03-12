<?php

namespace App\Http\Controllers\Api;

use App\Models\address;
use App\Http\Requests\insert\address_insert;

class AddressC extends ApiController
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new address;
    }
    
    public function receive_insert(address_insert $request)
    {
        $this->insert($request->all());
        return true;
    }
}
