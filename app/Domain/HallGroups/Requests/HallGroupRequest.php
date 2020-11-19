<?php

namespace App\Domain\HallGroups\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HallGroupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
