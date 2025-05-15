<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Facades\Settings as SettingsFacade;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $key
 * @property mixed $value
 * @property bool $cacheable
 */
class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = ['key', 'value', 'cacheable'];

    protected static function boot(): void
    {
        parent::boot();

        static::updated(fn($model) => SettingsFacade::delete($model->attributes['key']));

        static::deleted(fn($model) => SettingsFacade::delete($model->attributes['key']));
    }
}
