<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class dish_insert extends FormRequest
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
            'name' => ['required','string'],
            'status' => ['string'],
            'img' => ['string','min:0'],
            'description' => ['string'],
            'dish_menu.*.menu_id'=>['int','exists:menu,id'],
            'dish_menu.*.price'=>['required','numeric','min:0'],
            'dish_menu.*.start_discount'=>['date'],
            'dish_menu.*.end_discount'=>['date'],
            'dish_menu.*.limit' => ['int','min:0'],
            'type' => ['array'],
            'type.*.subcategory_id' => ['int','exists:subcategory,id'],
        ];
    }
}
