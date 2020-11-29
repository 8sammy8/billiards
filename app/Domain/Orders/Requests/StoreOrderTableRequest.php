<?php

namespace App\Domain\Orders\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderTableRequest extends FormRequest
{
    public function rules()
    {
        return [
            'table_id' => 'required|integer',
            'rate_id' => 'required|integer',
            'limit' => 'required|integer',
            'limit_hour' => [
                'nullable', 'integer', 'min:1', 'max:24',
                    Rule::requiredIf(function (){
                    return request()->limit == config('settings.order_table_limits.LIMIT_TIME') && !request()->limit_min;
                })
            ],
            'limit_min' => [
                'nullable', 'integer', 'min:1', 'max:59',
                    Rule::requiredIf(function (){
                    return request()->limit == config('settings.order_table_limits.LIMIT_TIME') && !request()->limit_hour;
                })
            ],
            'limit_price' => [
                'nullable', 'integer', 'min:1000',
                Rule::requiredIf(function (){
                    return request()->limit == config('settings.order_table_limits.LIMIT_PRICE');
                })
            ]
        ];
    }

    public function authorize()
    {
        return true;
    }
}
