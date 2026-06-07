<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'value'])]
class Configuration extends Model
{
    protected $table = 'configuration';

    /**
     * Gets the value of a configuration setting by its key.
     *
     * @param string $key The key of the configuration setting.
     * @param mixed $default The default value to return if the key is not found.
     * 
     * @return mixed The value of the configuration setting, or the default value if not found.
     */
    public static function get($key, $default = null)
    {
        return static::where('key', '=', $key)->value('value') ?? $default;
    }
}
