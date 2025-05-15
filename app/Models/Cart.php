<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $menu_id
 * @property int $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user
 * @property-read Menu $menu
 */
class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $fillable = ['quantity'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCartItemPrice(): float|int
    {
        return $this->menu->foods->reduce(fn(int $carry, Food $item) => $carry + $item->price, 0);
    }

    public function getCartItemName(): string
    {
        return $this->menu->week_day . ' ' . $this->menu->name;
    }
}
