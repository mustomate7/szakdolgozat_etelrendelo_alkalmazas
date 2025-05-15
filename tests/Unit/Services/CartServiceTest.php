<?php

namespace Tests\Unit\Services;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\MenuWeek;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $cartService;

    public function setUp(): void
    {
        parent::setUp();
        $this->cartService = $this->app->make(CartService::class);

        $week = MenuWeek::factory(['calendar_year' => 2050, 'calender_week' => 1])->create();
        Menu::factory()
            ->count(5)
            ->create([
                'menu_week_id' => $week->id,
            ]);
        User::factory()->create();
    }

    public function test_does_cart_item_exists(): void
    {
        Cart::factory(['user_id' => 1, 'menu_id' => 1])->create();

        $exists = $this->cartService->doesCartItemExists(1, 1);
        $doesNotExist = $this->cartService->doesCartItemExists(1000, 1);

        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function test_save_cart_item_to_database(): void
    {
        $this->cartService->store(1, 2, 1);
        $this->cartService->store(3, 2, 2);

        $result = Cart::query()
            ->select()
            ->get();

        $this->assertTrue($result->contains('menu_id', '=', 1));
        $this->assertTrue($result->contains('menu_id', '=', 3));
        $this->assertTrue($result->contains('user_id', '=', 2));
        $this->assertCount(2, $result);
    }

    public function test_update_cart_item_with_null_quantity(): void
    {
        Cart::factory(['user_id' => 3, 'menu_id' => 1, 'quantity' => 1])->create();

        $addOne = $this->cartService->update(1, 3, null);

        $result = Cart::query()
            ->select()
            ->where('menu_id', '=', 1)
            ->where('user_id', '=', 3)
            ->get();

        $this->assertEquals(2, $addOne->quantity);
        $this->assertEquals($result[0]['quantity'], $addOne->quantity);
    }

    public function test_update_cart_item_with_greater_than_one_quantity(): void
    {
        Cart::factory(['user_id' => 4, 'menu_id' => 1, 'quantity' => 1])->create();

        $reWriteQuantity = $this->cartService->update(1, 4, 6);

        $result = Cart::query()
            ->select()
            ->where('menu_id', '=', 1)
            ->where('user_id', '=', 4)
            ->first();

        $this->assertEquals(6, $reWriteQuantity->quantity);
        $this->assertEquals(6, $result['quantity']);
    }

    public function test_update_cart_item_with_zero_quantity(): void
    {
        Cart::factory(['user_id' => 5, 'menu_id' => 1, 'quantity' => 1])->create();

        $zeroQuantity = $this->cartService->update(1, 5, 0);

        $result = Cart::query()
            ->select()
            ->where('menu_id', '=', 1)
            ->where('user_id', '=', 5)
            ->get();

        $this->assertFalse($zeroQuantity->exists);
        $this->assertEmpty($result);
    }

    public function test_delete_cart_item(): void
    {
        Cart::factory(['user_id' => 6, 'menu_id' => 1, 'quantity' => 1])->create();

        $this->cartService->delete(1, 6);

        $result = Cart::query()
            ->select()
            ->where('menu_id', '=', 1)
            ->where('user_id', '=', 4)
            ->get();

        $this->assertEmpty($result);
    }
}
