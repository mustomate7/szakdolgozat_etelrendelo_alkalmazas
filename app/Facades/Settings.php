<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed getData(string $key, string $default)
 * @method static bool delete(string $key)
 * @method static bool put(string $key, string $value)
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'settings';
    }
}
