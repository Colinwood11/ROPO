<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class printer_insert extends FormRequest
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
            'old' => ['bool'], 
            'printer' => ['int','max:3'],
            'order_ids' => ['required','array'],
            'order_ids.*' =>['required','int'],
            'table_number' => ['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/','exists:table,table_number'],
        ];
    }
}
