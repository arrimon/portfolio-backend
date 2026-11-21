<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * The model must define a `translations()` hasMany relation.
 */
trait HasTranslations
{
    public function translation(?string $locale = null): ?Model
    {
        $locale ??= app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        $this->loadMissing('translations');

        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', $fallback);
    }

    public function hasTranslation(string $locale): bool
    {
        $this->loadMissing('translations');

        return $this->translations->contains('locale', $locale);
    }

    public function t(string $field, ?string $locale = null): mixed
    {
        return $this->translation($locale)?->{$field};
    }
}
