<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class menu_insert extends FormRequest
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
            'name' => ['required','string','unique:menu,name'],
            'weight' => ['int','min:0'],
            'start_time' => ['required','date_format:H:i:s'],
            'end_time' =>['required','date_format:H:i:s'],
            'fixed_price' =>['required','numeric','min:0'],
        ];
    }
}
