<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;

class order_update_waiter extends FormRequest
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
        return parent::getValidatorInstance()->after(function($validator){
            // Call the after method of the FormRequest (see below)
            $this->after($validator);
        });
    }
    /**
     * Attach callbacks to be run after validation is completed.
     * 
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return callback
     */
    public function after($validator)
    {
        if ($this->somethingElseIsInvalid()) {
            //$validator->errors()->add('field', 'Something is wrong with this field!'); 
        }
        else
        {

        };
    }


    /**
     * Get the validation rules that a!pply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        return [
            'id' => ['required','exists:ordering,id'],
            'table_history_id' => ['exists:table_history,id','int','min:0'],
            'dish_id' => ['exists:dish,id','int','min:0'],
            'user_id' => ['exists:users,id','int','min:0'],
            'number' => ['int','min:0'],
            'que_number' => ['int'],
            'order_at' => ['date'],            
            'menu' => ['int','exists:menu,id'],
            'price' => ['numeric','min:0'],
            'variant' => ['string'],
            'status' => ['string'],
        ];
    }
}
