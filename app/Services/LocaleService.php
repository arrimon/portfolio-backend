<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LocaleService
{
    /** Active languages, default language first. */
    public function active(): Collection
    {
        return Language::active()->orderByDesc('is_default')->orderBy('sort_order')->get();
    }

    public function codes(): array
    {
        return $this->active()->pluck('code')->all();
    }

    public function defaultCode(): string
    {
        return Language::where('is_default', true)->value('code')
            ?? config('app.fallback_locale', 'en');
    }

    public function resolve(?string $requested): string
    {
        return in_array($requested, $this->codes(), true) ? $requested : $this->defaultCode();
    }

    /** Exactly one default language, enforced inside a transaction. */
    public function setDefault(string $code): void
    {
        DB::transaction(function () use ($code) {
            $language = Language::where('code', $code)->where('is_active', true)->firstOrFail();
            Language::where('id', '!=', $language->id)->update(['is_default' => false]);
            $language->update(['is_default' => true]);
        });
    }
}
