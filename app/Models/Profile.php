<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    use HasTranslations;

    protected $fillable = [
        'singleton_key', 'avatar_media_id', 'cv_media_id',
        'email', 'phone', 'location', 'is_available_for_work',
    ];

    protected function casts(): array
    {
        return ['is_available_for_work' => 'boolean'];
    }

    public static function singleton(): static
    {
        return static::firstOrCreate(['singleton_key' => 1]);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProfileTranslation::class);
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'avatar_media_id');
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cv_media_id');
    }
}
