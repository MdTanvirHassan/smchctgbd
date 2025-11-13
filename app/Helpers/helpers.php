<?php

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        $settings = Cache::remember('business_settings', 86400, function () {
            return Setting::all();
        });

        if ($lang == false) {
            $setting = $settings->where('type', $key)->first();
        } else {
            $setting = $settings->where('type', $key)->where('lang', $lang)->first();
            $setting = !$setting ? $settings->where('type', $key)->first() : $setting;
        }

        return $setting == null ? $default : $setting->value;
    }
}

if (!function_exists('is_active')) {
    function is_active($patterns)
    {
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }

        foreach ($patterns as $pattern) {
            if (request()->routeIs($pattern)) {
                return 'active';
            }
        }

        return '';
    }
}

if (!function_exists('is_menu_open')) {
    function is_menu_open($patterns)
    {
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }

        foreach ($patterns as $pattern) {
            if (request()->routeIs($pattern)) {
                return 'show';
            }
        }

        return '';
    }
}
