<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class dish_update extends FormRequest
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
            'id' => ['required','int','exists:dish_variant,id'],
            'name' => ['required','string','unique:dish_variant,name'.$this->get('id')],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],

        ];
    }
}
