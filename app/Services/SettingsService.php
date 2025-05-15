<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    use HasFactory;

    protected const CACHE_TTL = 10 * 60;
    protected const PREFIX = 'SETTINGS_';

    private function getKey($key): string
    {
        return self::PREFIX . $key;
    }

    public function getData(string $key, string $default = null): string|null
    {
        $result = Cache::get($this->getKey($key), $default);

        if (!is_null($result)) {
            return $result;
        }

        $setting = Settings::query()
            ->where('key', '=', $key)
            ->first();

        if (!($setting instanceof Settings)) {
            return $default;
        }

        if ($setting->cacheable) {
            $this->put($key, $setting->value);
        }

        return $setting->value;
    }

    public function delete(string $key): bool
    {
        return Cache::delete($this->getKey($key));
    }

    public function put(string $key, string $value): bool
    {
        return Cache::put($this->getKey($key), $value, self::CACHE_TTL);
    }
}
