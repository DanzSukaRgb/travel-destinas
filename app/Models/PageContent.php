<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    protected $fillable = ['page', 'key', 'label', 'value', 'type', 'sort_order'];

    // Cache TTL: 24 hours
    protected const CACHE_TTL = 86400;

    /**
     * Get a single content value for a page+key.
     * Falls back to $default if not found.
     */
    public static function get(string $page, string $key, string $default = ''): string
    {
        $cacheKey = "pcms.{$page}.{$key}";

        return Cache::remember($cacheKey, static::CACHE_TTL, function () use ($page, $key, $default) {
            return static::where('page', $page)->where('key', $key)->value('value') ?? $default;
        });
    }

    /**
     * Get all content for a page as a Collection keyed by 'key'.
     */
    public static function forPage(string $page): \Illuminate\Support\Collection
    {
        $cacheKey = "pcms.page.{$page}";

        return Cache::remember($cacheKey, static::CACHE_TTL, function () use ($page) {
            return static::where('page', $page)->orderBy('sort_order')->get();
        });
    }

    /**
     * Decode a JSON-type field, returning $default on failure.
     */
    public static function json(string $page, string $key, array $default = []): array
    {
        $raw = static::get($page, $key, '');
        if (empty($raw)) return $default;
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : $default;
    }

    /**
     * Clear all cache for one page (call after admin saves).
     */
    public static function clearCache(string $page): void
    {
        Cache::forget("pcms.page.{$page}");
        foreach (static::where('page', $page)->pluck('key') as $key) {
            Cache::forget("pcms.{$page}.{$key}");
        }
    }

    /**
     * Upsert a value — insert if not exists, update if exists.
     */
    public static function set(string $page, string $key, ?string $value): void
    {
        static::where('page', $page)->where('key', $key)->update(['value' => $value]);
        Cache::forget("pcms.{$page}.{$key}");
        Cache::forget("pcms.page.{$page}");
    }
}
