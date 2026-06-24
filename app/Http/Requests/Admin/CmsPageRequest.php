<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CmsPageRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $pageId = $this->route('page')?->id;

        return [
            'title'           => 'required|string|max:200',
            'slug'            => ['required', 'string', 'max:200', 'alpha_dash', Rule::unique('cms_pages', 'slug')->ignore($pageId)],
            'banner_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'description'     => 'nullable|string',
            'status'          => 'required|in:published,draft',
            'seo_title'       => 'nullable|string|max:160',
            'seo_description' => 'nullable|string|max:320',
            'seo_keywords'    => 'nullable|string|max:255',
        ];
    }
}
