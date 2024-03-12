<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class langvar_insert extends FormRequest
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
            'name' => ['required','string',Rule::unique('langvar','name')->where('lang',$this->get('lang')),Rule::exists('namelang','name')],
            'lang' => ['required','string',Rule::unique('langvar','lang')->where('name',$this->get('name'))],
            'value' => ['required','string'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],

        ];
    }
}
