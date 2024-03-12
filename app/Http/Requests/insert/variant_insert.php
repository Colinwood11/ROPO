<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class variant_insert extends FormRequest
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
            'dish_variant_name' => ['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/',Rule::unique('variant','dish_variant_name')->where('dish_id',$this->get('dish_id'))],
            'dish_id' => ['required','int','exists:dish,id',Rule::unique('variant','dish_id')->where('dish_variant_name',$this->get('dish_variant_name'))],
        ];
    }
}
