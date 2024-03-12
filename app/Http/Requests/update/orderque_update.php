<?php

namespace App\Http\Requests\update;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

use App\Models\TableHistory;
use App\Models\Table;
use App\Models\OrderingNow;
use App\Models\Ordering;

class orderque_update extends FormRequest
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

        $array = $this->all();
        foreach ($array as &$a) {
            //$a['order_at'] = Carbon::now();
            if (isset($a['table_history_id'])) {
                $table = TableHistory::find($a['table_history_id']);
                if (isset($table)) {
                    $code = Table::find($table->table_id)->code;

                    if (isset($code) && $code != "") {

                        if ($a['code'] == $code) {
                            $a['code'] = true;
                            //unset($a['code']);
                        } else {
                            $a['code'] = false;
                        }
                    }
                }
            }
        }

        $this->merge($array);
    }

    /**
     * Get the validation rules that a!pply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            //'id' => ['required', 'int', 'exists:Orderque,id'],
            //'dish_id' => ['exists:dish,id', 'int', 'min:0'],
            //'user_id' => ['exists:users,id', 'int', 'min:0'],
            //'order_at' => ['date'],
            //'table_history_id' => ['exists:table_history,id', 'int', 'min:0'],
            //'menu' => ['int', 'exists:menu,id'],
            //'price' => ['numeric', 'min:0'],
            //'note' => ['string'],
            //'number' => ['int','min:1'],

            'updatelist' => ['required','array'],
            'updatelist.*.id' => ['required','int','exists:OrderingNow,id'],
            'updatelist.*.dish_id' => ['exists:dish,id', 'int', 'min:0'],
            'updatelist.*.table_history_id' => ['exists:table_history,id', 'int', 'min:0'],
            'updatelist.*.menu' => ['int', 'exists:menu,id'],
            'updatelist.*.number' => ['int','min:1'],
            'updatelist.*.status' => ['string'],
            'updatelist.*.note' => ['string'],
            'updatelist.*.price' => ['numeric', 'min:0'],
            'updatelist.*.user_id' => ['exists:users,id', 'int', 'min:0'],
            'updatelist.*.order_at' => ['date'],
        ];
    }
}
