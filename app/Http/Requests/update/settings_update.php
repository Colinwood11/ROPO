<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;

class settings_update extends FormRequest
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
            'name' => ['required','string','exists:settings,name'],
            'value' => ['required','string'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],
        ];
    }
}
