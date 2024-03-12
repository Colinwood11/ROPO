<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class faq_insert extends FormRequest
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
            'question' => ['required','string','unique:faq,question'],
            'answer' => ['required','string'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],

        ];
    }
}
