<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlogCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('category')?->id;
        return [
            'name'        => 'required|string|max:120',
            'slug'        => 'nullable|string|max:160|unique:blog_categories,slug,' . $id,
            'description' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|max:3072',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (empty($this->slug) && $this->name) {
            $this->merge(['slug' => Str::slug($this->name)]);
        }
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
