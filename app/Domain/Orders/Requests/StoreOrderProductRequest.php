<?php

namespace App\Domain\Orders\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_id' => 'nullable|integer',
            'products' => 'required|array',
            'products.*.id' => 'required|integer',
            'products.*.quantity' => 'required|integer',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
