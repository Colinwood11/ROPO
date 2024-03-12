<?php

namespace App\Http\Requests\delete;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class langvar_delete extends FormRequest
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
            'name' => ['required','string','exists:langvar,name'],
            'lang' => ['required','string','exists:langvar,lang'],
        ];
    }
}
