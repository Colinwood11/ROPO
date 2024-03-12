<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;

class TableChangeMenuRequest extends FormRequest
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
            'id' => ['required','exists:table_res,id'],
            'menu_id' => ['required','exists:menu,id']
        ];
    }
}
