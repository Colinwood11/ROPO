<?php

namespace App\Http\Requests\delete;

use Illuminate\Foundation\Http\FormRequest;


class order_delete extends FormRequest
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
        
    }


    /**
     * Get the validation rules that a!pply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        return [
            'id' => ['required','exists:OrderingNow,id'],
        ];
    }
}
