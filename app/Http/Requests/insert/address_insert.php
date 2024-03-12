<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class address_insert extends FormRequest
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
            'region' => ['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/',Rule::exists('province','regione_province')],
            'province' =>['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/','max:2',Rule::exists('province','sigla_province')],
            'city' => ['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/'],
            'via' => ['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/'],
            'number' => ['string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/'],
            'name' => ['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/','max:40'],
            'surname' => ['required','string','regex:/^[^(|]~`!%^&*=};:?><’)]*$/','max:40'],
            'phone' => ['required','numeric','digits:10'],
            'user_id' => ['required','int','exists:users,id'],
        ];
    }
}
