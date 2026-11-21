<?php

namespace App\Models;

use App\Enums\SectionKey;
use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasTranslations;

    protected $fillable = ['key', 'is_enabled', 'sort_order', 'variant'];

    protected function casts(): array
    {
        return ['key' => SectionKey::class, 'is_enabled' => 'boolean'];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(SectionTranslation::class);
    }

    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
