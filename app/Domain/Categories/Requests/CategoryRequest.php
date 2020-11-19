<?php

namespace App\Domain\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
