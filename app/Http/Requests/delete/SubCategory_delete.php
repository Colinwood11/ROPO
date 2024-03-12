<?php

namespace App\Http\Requests\delete;

use Illuminate\Foundation\Http\FormRequest;

class SubCategory_delete extends FormRequest
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
            'id' => ['required','int','exists:subcategory,id'],
        ];
    }
}
