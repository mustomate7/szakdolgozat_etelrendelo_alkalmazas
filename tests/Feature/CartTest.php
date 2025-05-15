<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\MenuWeek;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public static function provideInputData(): array
    {
        return [
            'menu input missing' => [
                'menu',
                [
                    'quantity' => 1,
                ],
            ],
            'menu input invalid' => [
                'menu',
                [
                    'menu' => 'invalidInput',
                    'quantity' => 1,
                ],
            ],
            'quantity input invalid' => [
                'quantity',
                [
                    'menu' => 1,
                    'quantity' => 'invalidInput',
                ],
            ],
        ];
    }

    public function test_cart_api_returns_the_expected_response(): void
    {
        $week = MenuWeek::factory(['calendar_year' => 2050, 'calender_week' => 1])->create();
        $menu = Menu::factory()->create(['menu_week_id' => $week->id]);
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withHeaders([
                "X-CSRF-Token" => csrf_token(),
                "Content-Type" => "application/json",
            ])
            ->postJson(route('cart.add'), [
                'menu' => $menu->id,
                'quantity' => 5,
            ]);

        $response
            ->assertStatus(201)
            ->assertSessionHasNoErrors()
            ->assertJson([
                'data' => [
                    'menu_id' => $menu->id,
                    'quantity' => 5,
                ],
            ]);
    }

    /**
     * @dataProvider provideInputData
     */
    public function test_cart_api_validates_inputs(string $key, array $data): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->withHeaders([
                "X-CSRF-Token" => csrf_token(),
                "Content-Type" => "application/json",
            ])
            ->postJson(route('cart.add'), $data);

        $cart = Cart::query()->select()->get();

        $response->assertJsonValidationErrorFor($key);
        $this->assertEmpty($cart);
    }

    public function test_cart_api_without_authenticated_user(): void
    {
        $response = $this
            ->withHeaders([
                "X-CSRF-Token" => csrf_token(),
                "Content-Type" => "application/json",
            ])
            ->postJson(route('cart.add'), [
                'menu' => 1,
                'quantity' => 1,
            ]);

        $cart = Cart::query()->select()->get();

        $response->assertUnauthorized();
        $this->assertEmpty($cart);
    }
}
