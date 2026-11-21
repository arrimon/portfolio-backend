<?php

namespace App\Services\Admin;

use App\Models\Setting;
use App\Services\LocaleService;
use App\Support\ContentCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingService
{
    public function __construct(private LocaleService $locales) {}

    /** For the admin form: Setting models keyed by key. */
    public function forAdmin(): Collection
    {
        return Setting::with('translations')->get()->keyBy('key');
    }

    /** Only allowlisted keys from config/portfolio.php are ever written. */
    public function update(array $data): void
    {
        $codes = $this->locales->codes();

        DB::transaction(function () use ($data, $codes) {
            foreach (config('portfolio.settings') as $group => $definitions) {
                foreach ($definitions as $key => $def) {
                    $setting = Setting::firstOrCreate(
                        ['key' => $key],
                        ['group' => $group, 'type' => $def['translatable'] ? 'translated' : 'plain']
                    );

                    if ($def['translatable']) {
                        foreach ($codes as $code) {
                            $value = $data['translated'][$key][$code] ?? null;

                            if (blank($value)) {
                                $setting->translations()->where('locale', $code)->delete();
                            } else {
                                $setting->translations()->updateOrCreate(['locale' => $code], ['value' => $value]);
                            }
                        }
                    } elseif (array_key_exists($key, $data['plain'] ?? [])) {
                        $setting->update(['value' => $data['plain'][$key]]);
                    }
                }
            }

            DB::afterCommit(fn () => ContentCache::bump());
        });
    }

    /** Public read (used by Module 5 API). Cached with a versioned key; falls back to default locale. */
    public function public(string $locale): array
    {
        return Cache::remember(ContentCache::key("settings:{$locale}"), 3600, function () use ($locale) {
            $fallback = $this->locales->defaultCode();

            return Setting::with('translations')->get()->mapWithKeys(function (Setting $s) use ($locale, $fallback) {
                $value = $s->type === 'translated'
                    ? ($s->translations->firstWhere('locale', $locale)?->value
                        ?: $s->translations->firstWhere('locale', $fallback)?->value)
                    : $s->value;

                return [$s->key => $value];
            })->all();
        });
    }
}
