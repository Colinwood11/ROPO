<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class type_insert extends FormRequest
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
            'subcategory_id' => ['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/',Rule::unique('type','subcategory_id')->where('dish_id',$this->get('dish_id'))],
            'dish_id' => ['required','int','exists:dish,id',Rule::unique('type','dish_id')->where('subcategory_id',$this->get('subcategory_id'))],
        ];
    }
}
