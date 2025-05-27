<?php

namespace App;

use App\Models\Setting;

if (!function_exists('get_setting')) {
    function get_setting($col)
    {
        static $settings = null;

        if (is_null($settings)) {
            $settings = Setting::where('key', $col)->value('value');
        }

        return $settings->$col ?? null;
    }
}
