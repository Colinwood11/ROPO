<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class dish_menu_insert extends FormRequest
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
            'dish_id' => ['required','exists:dish,id',Rule::unique('dish_menu','dish_id')->where('menu_id',$this->get('menu_id'))],
            'menu_id' => ['required','exists:mode,id',Rule::unique('dish_menu','menu_id')->where('dish_id',$this->get('dish_id'))],
        ];
    }
}
