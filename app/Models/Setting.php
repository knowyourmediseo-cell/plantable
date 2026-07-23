<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'sort_order',
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('settings');
        });

        static::deleted(function () {
            Cache::forget('settings');
        });
    }

    public static function get($key, $default = null)
    {
        $settings = Cache::rememberForever('settings', function () {
            return static::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );
    }

    public static function getGroup($group)
    {
        return static::where('group', $group)
            ->orderBy('sort_order')
            ->pluck('value', 'key')
            ->toArray();
    }

    public static function has($key)
    {
        $settings = Cache::rememberForever('settings', function () {
            return static::pluck('value', 'key')->toArray();
        });

        return array_key_exists($key, $settings);
    }
}
