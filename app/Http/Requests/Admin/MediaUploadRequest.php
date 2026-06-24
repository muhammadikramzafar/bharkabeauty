<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'files'          => 'required|array|min:1|max:20',
            'files.*'        => 'required|file|max:51200|mimes:jpg,jpeg,png,gif,webp,svg,mp4,mov,avi,pdf,doc,docx,xls,xlsx',
            'alt_text'       => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'files.*.max'   => 'Each file must not exceed 50 MB.',
            'files.*.mimes' => 'Unsupported file type.',
        ];
    }
}
