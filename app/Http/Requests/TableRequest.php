<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'boolean',
            'hall_group_id' => 'required|integer',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
