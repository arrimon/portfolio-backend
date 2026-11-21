<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

/**
 * Versioned cache keys (works on every cache driver, no tags needed).
 * Call ContentCache::bump() after a content write is committed.
 */
class ContentCache
{
    public static function version(): int
    {
        return (int) Cache::get('content_version', 1);
    }

    public static function key(string $name): string
    {
        return 'content:v'.self::version().':'.$name;
    }

    public static function bump(): void
    {
        Cache::add('content_version', 1);
        Cache::increment('content_version');
    }
}
