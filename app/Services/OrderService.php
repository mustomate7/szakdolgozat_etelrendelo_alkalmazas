<?php

namespace App\Services;

use App\Dtos\OrderDto;
use App\Dtos\StripeWebhookDto;
use App\Exceptions\DatabaseException;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderService
{
    private CartService $cartService;
    private OrderItemsService $orderItemsService;

    public function __construct(CartService $cartService, OrderItemsService $orderItemsService)
    {
        $this->cartService = $cartService;
        $this->orderItemsService = $orderItemsService;
    }

    /**
     * @throws DatabaseException
     */
    public function saveOrderData(int $userId): OrderDto
    {
        $carts = Cart::query()->hydrate($this->cartService->listCartItemsForUser($userId)->toArray());

        $totalPrice = $carts->reduce(fn(int $carry, Cart $item) =>
            $carry + $item->getCartItemPrice() * $item->quantity, 0);

        $order = $this->saveOrder($userId, $totalPrice);
        $orderItems = $this->orderItemsService->saveOrderItems($carts, $order->id);

        return new OrderDto($order, $orderItems);
    }

    /**
     * @throws DatabaseException
     */
    private function saveOrder(int $userId, int $totalPrice): Order
    {
        $order = new Order();
        $order->user_id = $userId;
        $order->stripe_payment_id = '';
        $order->total_price = $totalPrice;
        $order->discount = 0;
        $order->status = config('stripe.default_status');
        $order->shipping_address = '';

        if (!$order->save()) {
            throw new DatabaseException('Save to database failed!');
        }

        return $order;
    }

    /**
     * @throws DatabaseException
     */
    public function updateOrder(StripeWebhookDto $webhookResponse): Order
    {
        $order = Order::query()->find($webhookResponse->order_id);

        if (!$order instanceof Order) {
            throw new ModelNotFoundException();
        }

        $order->stripe_payment_id = $webhookResponse->payment_id;
        $order->status = $webhookResponse->payment_status;
        $order->shipping_address = $webhookResponse->shipping_address;

        if (!$order->save()) {
            throw new DatabaseException();
        }

        return $order;
    }
}
