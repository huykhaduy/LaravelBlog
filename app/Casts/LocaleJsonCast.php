<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class LocaleJsonCast implements CastsAttributes 
{
    public function get($model, string $key, $value, array $attributes)
    {
        // Get current locale
        $locale = app()->getLocale();
        
        // Get fallback locale
        $fallback = config('app.fallback_locale');

        $json = json_decode($value, true);

        if (!is_array($json)) {
            return null;
        }

        return $json[$locale] ?? $json[$fallback] ?? null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        $locale = app()->getLocale();
        $json = json_decode($attributes[$key] ?? '[]', true);

        if (!is_array($json)) {
            $json = [];
        }
        
        $json[$locale] = $value;

        return json_encode($json);
    }
}