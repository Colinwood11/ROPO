<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

use App\Models\table_history;
use App\Models\table;

class order_insert_staff extends FormRequest
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

    protected function prepareForValidation()
    {

    }

    /**
     * Get the validator instance for the request and 
     * add attach callbacks to be run after validation 
     * is completed.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {   

    }
    /**
     * Attach callbacks to be run after validation is completed.
     * 
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return callback
     */
    public function after($validator)
    {

    }


    /**
     * Get the validation rules that a!pply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        return [
            'cart.*.dish_id' => ['required', 'exists:dish,id', 'int', 'min:0'],
            'cart.*.menu' => ['required', 'int', 'exists:menu,id'],
            'cart.*.variant' => ['array'],
            'cart.*.variant.*.dish_variant_name' => ['string', 'exists:dish_variant,name'], //有点危险
            'cart.*.variant.*.dose' => ['int'],
            'cart' => ['required','array'],
            'note' => ['string'],
            'table_history_id' => ['exists:table_history,id', 'int', 'min:0'], //generated here!
        ];
    }
}
