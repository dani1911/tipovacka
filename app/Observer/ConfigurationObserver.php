<?php

namespace App\Observer;

use App\Models\Configuration;
use App\Support\AppConfig;

class ConfigurationObserver
{
    public function saved(Configuration $config): void
    {
        AppConfig::flush(strtolower($config->key));
    }
}