<?php

namespace App\Http\Controllers\Api;

use App\Models\DishVariant;
use App\Http\Requests\insert\dish_variant_insert;

class DishVariantC extends ApiController
{
    public function __construct()
    {
        $this->_model = new DishVariant;
    }

    protected function get_key_process(&$collection)
    {
        $collection->variant->makehidden(['dish_variant_name','dish_id']);
       
    }

    public function receive_insert(dish_variant_insert $request)
    {
        return $this->insert($request->all());
    }
}
