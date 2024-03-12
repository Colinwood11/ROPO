<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class menu_update extends FormRequest
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
            'id' => ['required','int','exists:menu,id'],
            'name' => ['string'],
            'weight' => ['int','min:0'],
            'start_time' => ['date_format:H:i:s'],
            'end_time' =>['date_format:H:i:s'],
            'fixed_price' =>['numeric','min:0'],
        ];
    }
}
