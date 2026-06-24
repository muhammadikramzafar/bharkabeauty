<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    protected $fillable = [
        'name', 'file_name', 'path', 'url',
        'mime_type', 'type', 'size', 'alt_text', 'disk', 'uploaded_by',
    ];

    protected $appends = ['human_size'];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function delete()
    {
        Storage::disk($this->disk)->delete($this->path);
        return parent::delete();
    }

    public static function typeFromMime(string $mime): string
    {
        return match(true) {
            str_starts_with($mime, 'image/') => 'image',
            str_starts_with($mime, 'video/') => 'video',
            $mime === 'application/pdf'       => 'pdf',
            default                           => 'document',
        };
    }
}
