<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class Appointment_insert extends FormRequest
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
            'user_id' => ['required','int','exists:users,id'],
            'time' => ['required','after_or_equal:'.Carbon::now(),'exists:user,id'],
            'number_person' => ['required','int','min:0'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],

        ];
    }
}
