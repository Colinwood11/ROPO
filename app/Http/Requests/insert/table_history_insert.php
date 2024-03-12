<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;

class table_history_insert extends FormRequest
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
            'table_id' => ['required','int','exists:table,id'],
            'num_person' =>['int'],
            //'start_time' => ['required','date'],
            //'end_time' => ['date'],
            //'table_discount' => ['numeric','min:0'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],
        ];
    }
}
