<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;

class order_confirm_staff extends FormRequest
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

    protected function prepareForValidation()
    {
        
    }

    /**
     * Get the validation rules that a!pply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'id' => ['required', 'int', 'exists:OrderingNow,id'],
            'que_number' => ['required', 'int', 'min:1', 'max:255'],
            //'status' => ['required','string'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],

        ];
    }
}
