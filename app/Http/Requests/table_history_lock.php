<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class table_history_lock extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    { 

        return [
            'id' => ['required','int','exists:table_history,id'],
        ];
    }
}
