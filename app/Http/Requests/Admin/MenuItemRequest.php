<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'menu_id'     => 'required|exists:menus,id',
            'parent_id'   => 'nullable|exists:menu_items,id',
            'title'       => 'required|string|max:100',
            'url'         => 'nullable|string|max:500',
            'cms_page_id' => 'nullable|exists:cms_pages,id',
            'target'      => 'in:_self,_blank',
            'sort_order'  => 'integer|min:0',
        ];
    }
}
