<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * @property $id
 * @property $menu_week_id
 * @property $name
 * @property $week_day
 * @property $created_at
 * @property $updated_at
 *
 * @property-read MenuWeek menuWeek
 * @property-read Collection<MenuItem> menuItems
 * @property-read Cart|null cartItem
 * @property-read Collection<Food> foods
 */
class Menu extends Model
{
    use HasFactory;

    public function menuWeek(): BelongsTo
    {
        return $this->belongsTo(MenuWeek::class);
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function cartItem(): HasOne
    {
        return $this->hasOne(Cart::class)->where('user_id', '=', Auth::id() ?? null);
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'menu_items');
    }
}
