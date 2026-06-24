<?php

namespace App\Http\Requests\Admin;

use App\Models\BlogPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlogPostRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('post')?->id;
        return [
            'title'           => 'required|string|max:220',
            'slug'            => 'nullable|string|max:250|unique:blog_posts,slug,' . $id,
            'excerpt'         => 'nullable|string|max:600',
            'content'         => 'nullable|string',
            'featured_image'  => 'nullable|image|max:5120',
            'blog_category_id'=> 'nullable|exists:blog_categories,id',
            'user_id'         => 'nullable|exists:users,id',
            'tags'            => 'nullable|array',
            'tags.*'          => 'exists:blog_tags,id',
            'seo_title'       => 'nullable|string|max:160',
            'seo_description' => 'nullable|string|max:320',
            'seo_keywords'    => 'nullable|string|max:255',
            'status'          => 'required|in:draft,published,scheduled',
            'published_at'    => 'nullable|date',
            'sort_order'      => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'published_at.required_if' => 'A publish date/time is required when scheduling a post.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $id = $this->route('post')?->id;
        if (empty($this->slug) && $this->title) {
            $this->merge(['slug' => BlogPost::uniqueSlug($this->title, $id)]);
        }
        if (empty($this->status)) {
            $this->merge(['status' => 'draft']);
        }
        if (!$this->filled('user_id')) {
            $this->merge(['user_id' => auth()->id()]);
        }
    }
}
