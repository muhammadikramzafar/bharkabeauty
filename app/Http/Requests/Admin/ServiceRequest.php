<?php

namespace App\Http\Requests\Admin;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('service')?->id;

        return [
            'service_category_id' => 'nullable|exists:service_categories,id',
            'title'               => 'required|string|max:200',
            'slug'                => 'nullable|string|max:220|unique:services,slug,' . $id,
            'excerpt'             => 'nullable|string|max:500',
            'description'         => 'nullable|string',
            'banner_image'        => 'nullable|image|max:5120',
            'featured_image'      => 'nullable|image|max:3072',
            'price'               => 'nullable|string|max:100',
            'duration'            => 'nullable|string|max:80',
            'seo_title'           => 'nullable|string|max:160',
            'seo_description'     => 'nullable|string|max:320',
            'seo_keywords'        => 'nullable|string|max:255',
            'sort_order'          => 'nullable|integer|min:0',
            'status'              => 'required|in:published,draft',
        ];
    }

    protected function prepareForValidation(): void
    {
        $id = $this->route('service')?->id;

        if (empty($this->slug) && $this->title) {
            $this->merge(['slug' => Service::uniqueSlug($this->title, $id)]);
        }

        if (empty($this->status)) {
            $this->merge(['status' => 'draft']);
        }
    }
}
