<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:100',
            'location'  => 'required|in:header,footer,mobile',
            'is_active' => 'boolean',
        ];
    }
}
