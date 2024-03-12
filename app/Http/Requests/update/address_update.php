<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class address_update extends FormRequest
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
            'id' => ['required','exists:address,id'],
            'region' => ['required','string','max:2',Rule::exist('province','regione_province')],
            'province' => ['required','string',Rule::exist('province','sigla_province')],
            'city' => ['required','string'],
            'via' => ['required','string'],
            'number' => ['string'],
            'name' => ['required','string','max:40'],
            'surname' => ['required','string','max:40'],
            'phone' => ['required','numeric','digits:10'],
            'user_id' => ['required','int','exists:user,id'],
        ];
    }
}
