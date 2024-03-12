<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;

class SubCategory_update extends FormRequest
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
        #dump($this->get('name'));
        return [
            'id' => ['required','int','exists:subcategory,id'],
            'name' => ['required','string','unique:subcategory,name,'.$this->get('id')],
            'Category_Catname' => ['string','exists:category,Catname'],
            'weight' => ['int','min:0'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],
        ];
    }
}
