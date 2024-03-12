<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class order_cash extends FormRequest
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
            'num_person'=>['required','numeric','min:0'],
            'ids' =>['array'],
            'ids.*.id' => ['required','int','exists:OrderingNow,id'],
            'ids.*.number' => ['int','min:0'],
            'ids.*.price' => ['numeric','min:0'],
            'queids' => ['array'],
            'queids.*.id' => ['required','int','exists:Orderque,id'],
            'queids.*.number' => ['int','min:0'],
            'queids.*.price' => ['numeric','min:0'],
            //'status' => ['required','string'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],

        ];
    }
}
