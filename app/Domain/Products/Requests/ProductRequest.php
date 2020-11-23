<?php

namespace App\Domain\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'              => 'required|string|max:255',
            'code'              => 'nullable|integer',
            'unit'              => 'nullable|integer',
            'price'             => 'nullable|integer|gte:purchase_price',
            'purchase_price'    => 'nullable|integer|lte:price',
            'remainder'         => 'nullable|integer',
            'status'            => 'boolean',
            'img'               => 'nullable|mimes:jpg,jpeg,png|max:10000',
            'category_id'       => 'required|integer',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
