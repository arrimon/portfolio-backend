<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use SoftDeletes;

    protected $fillable = ['disk', 'path', 'original_name', 'mime_type', 'size', 'uploaded_by'];

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /** Extend this list when new modules reference media (projects, posts ...). */
    public function isInUse(): bool
    {
        return Profile::where('avatar_media_id', $this->id)
            ->orWhere('cv_media_id', $this->id)
            ->exists();
    }
}
