<?php

namespace App\Support;

use App\Models\Configuration;
use App\Enums\Phase;
use Illuminate\Support\Facades\Cache;

class AppConfig
{
    public static function currentPhase(): ?Phase
    {
        $value = Cache::rememberForever(
            'config.current_phase',
            fn() => Configuration::get('CURRENT_PHASE')
        );

        return $value ? Phase::from($value) : null;
    }

    public static function flush(string $key): void
    {
        Cache::forget("config.{$key}");
    }
}