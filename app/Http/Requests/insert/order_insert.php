<?php

namespace App\Http\Requests\insert;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

use App\Models\TableHistory;
use App\Models\Table;
use Hamcrest\Type\IsNumeric;

class order_insert extends FormRequest
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

        $a = $this->all();

        if (isset($a['code']) && $a['code'] != "" && is_numeric($a['code'])) {
            $table = Table::where('code',$a['code'])->first();
            if (isset($table)) {
                $a['code'] = true;
                $a['table_history_id'] = $table->TableHistory->wherenull('end_time')->first()->id;
            } else {
                unset($a['table_history_id']);
                $a['code'] = false;
            }
        }
        else
        {   
            //guard the table history element
            unset($a['table_history_id']);
            $a['code'] = false;
            
        }

        $this->merge($a);
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
            //'cart.*.user_id' => ['exists:users,id','int','min:0'],
            //'cart.*.order_at' => ['date'],
            'cart.*.number' => ['required','numeric','min:0'],
            'cart.*.menu' => ['required', 'int', 'exists:menu,id'],
            'cart.*.note' => ['string'],
            'cart.*.variant' => ['array'],
            'cart.*.variant.*.dish_variant_name' => ['string', 'exists:dish_variant,name'], //有点危险
            'cart.*.variant.*.dose' => ['int'],
            //'cart.*.status' => ['required','string'],
            'cart' => ['required','array'],
            //'table_history_id' => ['exists:table_history,id','int','min:0','required_if:*.mode,diancan','required_if:*.mode,baocan'],
            'code' => ['bool', 'required_with:*.table_history,id', Rule::in([true])],
            'note' => ['string'],
            'table_history_id' => ['exists:table_history,id', 'int', 'min:0'],

        ];
    }
}
