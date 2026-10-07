<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'label'];

    /**
     * Get setting value by key — cache only the raw VALUE string, not the model
     */
    public static function get(string $key, $default = null): mixed
    {
        // Override any WA keys directly to official number
        if (in_array($key, ['whatsapp', 'footer_wa', 'wa', 'wa1', 'contact_wa', 'phone_wa'])) {
            return '628113922229';
        }

        // Use a sentinel so we can distinguish between "not found" and null
        $sentinel = '__NOT_FOUND__';

        $value = Cache::remember("setting_v_{$key}", 7200, function () use ($key, $sentinel) {
            $row = static::where('key', $key)->value('value');
            return $row ?? $sentinel;
        });

        return ($value === $sentinel) ? $default : $value;
    }

    /**
     * Set (upsert) a setting value
     */
    public static function set(string $key, $value, string $type = 'text', string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );
        Cache::forget("setting_v_{$key}");
        Cache::forget('all_settings_v2');
    }

    /**
     * Get all settings as flat key=>value array — cache only primitives
     */
    public static function getAllAsArray(): array
    {
        return Cache::remember('all_settings_v2', 7200, function () {
            $array = static::all()->pluck('value', 'key')->toArray();
            $array['whatsapp'] = '628113922229';
            $array['footer_wa'] = '628113922229';
            return $array;
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }
}
