<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'user_id', 'blog_category_id',
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'seo_title', 'seo_description', 'seo_keywords',
        'status', 'published_at', 'sort_order',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = static::uniqueSlug($model->title);
            }
            if ($model->status === 'published' && empty($model->published_at)) {
                $model->published_at = now();
            }
        });

        static::updating(function (self $model) {
            if ($model->isDirty('status') && $model->status === 'published' && empty($model->published_at)) {
                $model->published_at = now();
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 2;
        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    // ── Relationships ────────────────────────────────────────────

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'blog_post_id', 'blog_tag_id');
    }

    // ── Scopes ───────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'published')
              ->orWhere(function ($q2) {
                  $q2->where('status', 'scheduled')
                     ->where('published_at', '<=', now());
              });
        })->orderByDesc('published_at');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')->where('published_at', '>', now());
    }

    // ── Accessors ────────────────────────────────────────────────

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? Storage::disk('public')->url($this->featured_image) : null;
    }

    public function getReadTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        return max(1, (int) ceil($words / 200));
    }

    public function getIsLiveAttribute(): bool
    {
        if ($this->status === 'published') return true;
        if ($this->status === 'scheduled' && $this->published_at && $this->published_at->isPast()) return true;
        return false;
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'published' => 'Published',
            'scheduled' => $this->is_live ? 'Published' : 'Scheduled',
            default     => 'Draft',
        };
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
