<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class dish_filter_request extends FormRequest
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
            'menu_id' => ['required','int','exists:menu,id'],
            'type' => ['array'],  
            'type.*'=>['int','exists:subcategory,id']
        ];
    }
}
