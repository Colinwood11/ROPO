<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class order_update extends FormRequest
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
     * Get the validation rules that a!pply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'updatelist' => ['required','array'],
            'updatelist.*.id' => ['required','int','exists:OrderingNow,id'],
            'updatelist.*.dish_id' => ['exists:dish,id', 'int', 'min:0'],
            'updatelist.*.table_history_id' => ['exists:table_history,id', 'int', 'min:0'],
            'updatelist.*.menu' => ['int', 'exists:menu,id'],
            'updatelist.*.number' => ['int','min:0'],
            'updatelist.*.status' => ['string'],
            'updatelist.*.note' => ['string'],
            'updatelist.*.price' => ['numeric', 'min:0'],
            'updatelist.*.user_id' => ['exists:users,id', 'int', 'min:0'],
            'updatelist.*.order_at' => ['date'],
            'inform_printer' => ['int',Rule::in([0,1])],

        ];
    }
}
