<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message',
        'status', 'admin_notes', 'ip_address',
    ];

    public function scopeNew($query)   { return $query->where('status', 'new'); }
    public function scopeRead($query)  { return $query->where('status', 'read'); }

    public function markRead(): void
    {
        if ($this->status === 'new') $this->update(['status' => 'read']);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new'     => '#ef4444',
            'read'    => '#f59e0b',
            'replied' => '#22c55e',
            default   => '#9ca3af',
        };
    }
}
