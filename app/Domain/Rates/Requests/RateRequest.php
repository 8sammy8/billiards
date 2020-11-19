<?php

namespace App\Domain\Rates\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'start_at' => 'nullable|regex:#[0-9][0-9]:00#',
            'end_at' => 'nullable|regex:#[0-9][0-9]:00#',
            'hall_group_id' => 'required|integer',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
