<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $order_id
 * @property int $menu_id
 * @property string $name
 * @property int $price
 * @property int $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Order $order
 * @property-read Collection<Menu> $menu
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'menu_id',
        'name',
        'quantity',
        'price',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
