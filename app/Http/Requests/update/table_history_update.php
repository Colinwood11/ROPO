<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;

class table_history_update extends FormRequest
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
            'id' => ['required','int','exists:table_history,id'],
            'num_person' => ['numeric','min:0'],
            //'table_id' => ['int','exists:table,id'],
            //'start_time' => ['required','date'],
            //'end_time' => ['date'],
            //'table_discount' => ['numeric','min:0'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],
        ];
    }
}
