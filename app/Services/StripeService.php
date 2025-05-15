<?php

namespace App\Services;

use App\Dtos\OrderDto;
use App\Dtos\StripeWebhookDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;

class StripeService
{
    /**
     * @throws ApiErrorException
     */
    public function stripeCheckout(OrderDto $orderDto, string $email): \Stripe\Checkout\Session
    {
        Stripe::setAPiKey(config('stripe.stripe_sk'));
        return \Stripe\Checkout\Session::create([
            'line_items' => $this->createLineItems($orderDto->orderItems),
            'customer_email' => $email,
            'currency' => config('stripe.currency'),
            'mode' => config('stripe.mode'),
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel', $orderDto->order->id),
            'payment_intent_data' => ['metadata' => ['order_id' => $orderDto->order->id]],
            'shipping_address_collection' => ['allowed_countries' => ['HU']]
        ]);
    }

    private function createLineItems(Collection $orderItems): array
    {
        $lineItems = [];
        foreach ($orderItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => config('stripe.currency'),
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        }

        return $lineItems;
    }

    /**
     * @throws SignatureVerificationException
     */
    public function handleWebhooks(string $payload): StripeWebhookDto
    {
        Stripe::setApiKey(config('stripe.stripe_sk'));

        $endpointSecret = config('stripe.stripe_ws');
        $signatureHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        $event = \Stripe\Webhook::constructEvent($payload, $signatureHeader, $endpointSecret);

        return match ($event->type) {
            'charge.succeeded' => new StripeWebhookDto(
                200,
                $event->data->object->metadata->order_id,
                $event->data->object->payment_intent,
                config('stripe.succeeded_status'),
                ($event->data->object->shipping->address->postal_code . ' ' .
                $event->data->object->shipping->address->city . ' ' .
                $event->data->object->shipping->address->line1 . ' ' .
                $event->data->object->shipping->address->line2)
            ),
            'charge.failed' => new StripeWebhookDto(
                400,
                $event->data->object->metadata->order_id,
                $event->data->object->payment_intent,
                config('stripe.failed_status'),
            ),
            'payment_intent.succeeded', 'payment_intent.created', 'checkout.session.completed' =>
            new StripeWebhookDto(200),
            default => new StripeWebhookDto(400),
        };
    }
}
