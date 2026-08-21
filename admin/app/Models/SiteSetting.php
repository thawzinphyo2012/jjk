<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function allKeyed(): array
    {
        return static::query()->pluck('value', 'key')->all();
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }
}
