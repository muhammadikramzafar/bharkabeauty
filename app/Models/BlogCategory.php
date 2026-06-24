<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image', 'sort_order', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(fn(self $m) => $m->slug = $m->slug ?: Str::slug($m->name));
    }

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'blog_category_id');
    }

    public function publishedPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'blog_category_id')
            ->where(fn($q) => $q->where('status', 'published')
                ->orWhere(fn($q2) => $q2->where('status', 'scheduled')->where('published_at', '<=', now())));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
