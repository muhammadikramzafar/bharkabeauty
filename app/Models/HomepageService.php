<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageService extends Model
{
    protected $fillable = ['icon', 'icon_type', 'title', 'description', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
