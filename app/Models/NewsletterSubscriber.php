<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['email', 'name', 'status', 'token', 'subscribed_at', 'unsubscribed_at'];

    protected $casts = ['subscribed_at' => 'datetime', 'unsubscribed_at' => 'datetime'];

    protected static function booted(): void
    {
        static::creating(function (self $m) {
            $m->token         = Str::random(48);
            $m->subscribed_at = now();
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function unsubscribe(): void
    {
        $this->update(['status' => 'unsubscribed', 'unsubscribed_at' => now()]);
    }

    public function resubscribe(): void
    {
        $this->update(['status' => 'active', 'subscribed_at' => now(), 'unsubscribed_at' => null]);
    }
}
