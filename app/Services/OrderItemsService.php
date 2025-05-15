<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use App\Models\Cart;
use App\Models\OrderItem;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderItemsService
{
    /**
     * @throws DatabaseException
     */
    public function saveOrderItems(Collection $carts, int $order_id): Collection
    {
        $orderItems = $carts->map(function (Cart $cart) use ($order_id) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order_id;
            $orderItem->menu_id = $cart->menu_id;
            $orderItem->name = $cart->getCartItemName();
            $orderItem->price = $cart->getCartItemPrice();
            $orderItem->quantity = $cart->quantity;
            return $orderItem;
        });

        DB::beginTransaction();
        try {
            OrderItem::insert($orderItems->toArray());
            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }

        return $orderItems;
    }
}
