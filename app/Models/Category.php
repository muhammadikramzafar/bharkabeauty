<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image', 'parent_id', 'sort_order', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function parent()    { return $this->belongsTo(Category::class, 'parent_id'); }
    public function children()  { return $this->hasMany(Category::class, 'parent_id'); }
    public function products()  { return $this->hasMany(Product::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeRoots($q)  { return $q->whereNull('parent_id'); }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
