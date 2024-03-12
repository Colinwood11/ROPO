<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Category_update extends FormRequest
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
            'id' => ['required','int','exists:category,id'],
            'Catname' => ['string',Rule::unique('category','Catname')->where('id','<>',$this->get('id'))],
            'weight' => ['int','min:0'],

        ];
    }
}
