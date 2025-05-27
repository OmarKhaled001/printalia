<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    protected $fillable = [
        'key',
        'value',
    ];
    public static function clearCache(): void
    {
        Cache::forget('settings');
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::clearCache();
        });

        static::created(function () {
            self::clearCache();
        });
    }
}
