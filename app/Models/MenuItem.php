<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id', 'parent_id', 'title', 'url',
        'cms_page_id', 'target', 'sort_order',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function page()
    {
        return $this->belongsTo(CmsPage::class, 'cms_page_id');
    }

    public function getResolvedUrlAttribute(): string
    {
        if ($this->url) {
            return $this->url;
        }
        if ($this->page) {
            return route('cms.page', $this->page->slug);
        }
        return '#';
    }
}
