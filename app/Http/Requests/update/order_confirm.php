<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\OrderingNow;

class order_confirm extends FormRequest
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
        $order = OrderingNow::with(['TableHistory.table'])->find($a['id']);
        if (!isset($order)) {
            $a['code'] = false;
            $this->merge($a);
            return;
        }

        $table = $order->TableHistory->table;
        if (!isset($table)) {
            $a['code'] = false;
            $this->merge($a);
            return;
        }

        if (isset($a['code']) && $a['code'] != "" && is_numeric($a['code']) && $table->code == $a['code']) {
            $a['code'] = true;
        } else {
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
            'id' => ['required', 'int', 'exists:OrderingNow,id'],
            'que_number' => ['required', 'int', 'min:1', 'max:255'],
            'code' => ['required', 'int', Rule::in([true])]
            //'status' => ['required','string'],
            //'table_history_id' => ['exists:table_history_id','int','min:0'],

        ];
    }
}
