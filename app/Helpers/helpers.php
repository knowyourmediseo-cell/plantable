<?php

use App\Models\Setting;
use App\Models\Menu;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('menu')) {
    function menu($location)
    {
        return Menu::active()->location($location)->with('items.children')->first();
    }
}

if (!function_exists('format_price')) {
    function format_price($amount)
    {
        $symbol = Setting::get('currency_symbol', '₹');
        $position = Setting::get('currency_position', 'before');
        $formatted = number_format($amount, 2);
        
        return $position === 'before' ? $symbol . $formatted : $formatted . ' ' . $symbol;
    }
}

if (!function_exists('currency')) {
    function currency($amount, $showSymbol = true)
    {
        return format_price($amount);
    }
}

if (!function_exists('upload_image')) {
    function upload_image($file, $folder = 'uploads')
    {
        if (!$file) {
            return null;
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');
        
        return $path;
    }
}

if (!function_exists('delete_image')) {
    function delete_image($path)
    {
        if ($path && \Storage::disk('public')->exists($path)) {
            \Storage::disk('public')->delete($path);
        }
    }
}

if (!function_exists('breadcrumbs')) {
    function breadcrumbs($items)
    {
        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
        foreach ($items as $label => $url) {
            if ($url) {
                $html .= '<li class="breadcrumb-item"><a href="' . $url . '">' . $label . '</a></li>';
            } else {
                $html .= '<li class="breadcrumb-item active">' . $label . '</li>';
            }
        }
        $html .= '</ol></nav>';
        return $html;
    }
}

if (!function_exists('active_menu')) {
    function active_menu($route, $class = 'active')
    {
        return request()->routeIs($route) ? $class : '';
    }
}

if (!function_exists('truncate')) {
    function truncate($text, $length = 100, $suffix = '...')
    {
        return \Illuminate\Support\Str::limit($text, $length, $suffix);
    }
}

if (!function_exists('slug')) {
    function slug($text)
    {
        return \Illuminate\Support\Str::slug($text);
    }
}

if (!function_exists('time_ago')) {
    function time_ago($datetime)
    {
        return \Carbon\Carbon::parse($datetime)->diffForHumans();
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd M, Y')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('seo_title')) {
    function seo_title($title = null)
    {
        $siteName = setting('site_name', config('app.name'));
        return $title ? $title . ' - ' . $siteName : $siteName;
    }
}

if (!function_exists('current_route')) {
    function current_route()
    {
        return \Route::currentRouteName();
    }
}

if (!function_exists('is_active_route')) {
    function is_active_route($routes)
    {
        $routes = is_array($routes) ? $routes : [$routes];
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }
        return false;
    }
}
