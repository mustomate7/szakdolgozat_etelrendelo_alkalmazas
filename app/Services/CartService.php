<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartService
{
    /**
     * @throws \Throwable
     */
    public function store(int $menuId, int $userId, ?int $quantity): Cart
    {
        if ($this->doesCartItemExists($menuId, $userId)) {
            return $this->update($menuId, $userId, $quantity);
        }

        $cart = new Cart();
        $cart->menu_id = $menuId;
        $cart->user_id = $userId;
        $cart->quantity = $quantity ?? 1;

        if (!$cart->saveOrFail()) {
            throw new DatabaseException();
        }

        return $cart;
    }

    /**
     * @throws DatabaseException
     */
    public function update(int $menuId, int $userId, ?int $quantity): Cart
    {
        $cart = $this->cartItemByMenuAndUser($menuId, $userId)->first();

        if (!$cart instanceof Cart) {
            throw new ModelNotFoundException();
        }

        $updatedQuantity = $quantity ?? $cart->quantity + 1;
        if ($updatedQuantity <= 0) {
            return $this->delete($menuId, $userId);
        }

        if (!$cart->update(['quantity' => $updatedQuantity])) {
            throw new DatabaseException('Update failed!');
        }

        return $cart;
    }

    /**
     * @throws DatabaseException
     */
    public function delete(int $menuId, int $userId): Cart
    {
        $cart = $this->cartItemByMenuAndUser($menuId, $userId)->first();

        if (!$cart instanceof Cart) {
            throw new ModelNotFoundException();
        }

        if (!$cart->delete()) {
            throw new DatabaseException('Delete failed!');
        }

        return $cart;
    }

    public function doesCartItemExists(int $menuId, int $userId): bool
    {
        return $this->cartItemByMenuAndUser($menuId, $userId)->exists();
    }

    private function cartItemByMenuAndUser(int $menuId, int $userId): Builder
    {
        return Cart::query()
            ->where('menu_id', '=', $menuId)
            ->where('user_id', '=', $userId);
    }

    /**
     * @param int $userId
     * @return Collection<Cart>
     */
    public function listCartItemsForUser(int $userId): Collection
    {
        return Menu::query()
            ->select('cart.user_id', 'cart.id', 'cart.quantity', 'cart.menu_id', 'menus.name', 'menus.week_day')
            ->with(['foods.images'])
            ->join('cart', 'cart.menu_id', '=', 'menus.id')
            ->where('cart.user_id', '=', $userId)
            ->get();
    }

    /**
     * @throws DatabaseException
     */
    public function deleteCartByUser(int $userId): int
    {
        $result = Cart::query()->where('user_id', $userId)->delete();

        if (!$result) {
            throw new DatabaseException('Delete failed!');
        }

        return $result;
    }
}
