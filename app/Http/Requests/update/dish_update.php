<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;

class dish_update extends FormRequest
{
    /**
     * Determine if the user is authori!zed to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that a!pply to the request.
     *
     * @return array
     */
    public function rules()
    { 

        return [
            'id' => ['required','int','exists:dish,id'],
            'name' => ['required','string'],
            'status' => ['string'],
            'printer'=>['int','exists:printer_list,id'],
            'img' => ['string','min:0'],
            'description' => ['string'],
            'dish_menu'=>['array'],
            'dish_menu.*.dish_id'=>['int','exists:dish,id'],
            'dish_menu.*.menu_id'=>['int','exists:menu,id'],
            'dish_menu.*.price'=>['required','numeric','min:0'],
            'dish_menu.*.start_discount'=>['date'],
            'dish_menu.*.end_discount'=>['date'],
            'dish_menu.*.limit' => ['int','min:0'],
            'type' => ['array'],
            'type.*.subcategory_id' => ['int','exists:subcategory,id'],
            'variant' => ['array'],
            'variant.*.variant_id' => ['int','exists:dish_varint,id'],

        ];
    }
}
