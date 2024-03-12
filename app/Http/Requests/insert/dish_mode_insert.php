<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class dish_mode_insert extends FormRequest
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
            'dish_id' => ['required','exists:dish,id',Rule::unique('dish_mode','dish_id')->where('mode_id',$this->get('mode_id'))],
            'mode_id' => ['required','exists:mode,id',Rule::unique('dish_mode','mode_id')->where('dish_id',$this->get('dish_id'))],
            'price' => ['numeric','min:0'],
            'discounted_price' => ['numeric',Rule::RequiredIf(function (){
                return (null !== $this->get('start_discount') OR null !== $this->get('end_discount'));
            })],
            'start_discount' => ['date'],
            'end_discount' => ['date'],
        ];
    }
}
