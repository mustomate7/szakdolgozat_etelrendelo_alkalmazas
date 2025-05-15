<?php

namespace App\Dtos;

class StripeWebhookDto
{
    public int $status_code;
    public ?int $order_id;
    public ?string $payment_id;
    public ?string $payment_status;

    public ?string $shipping_address;

    public function __construct(
        int $status_code,
        ?int $order_id = null,
        ?string $payment_id = null,
        ?string $payment_status = null,
        ?string $shipping_address = ''
    ) {
        $this->order_id = $order_id;
        $this->payment_id = $payment_id;
        $this->payment_status = $payment_status;
        $this->status_code = $status_code;
        $this->shipping_address = $shipping_address;
    }

    public function hasResponse(): bool
    {
        return !is_null($this->order_id) && !is_null($this->payment_id);
    }

    public function paymentSuccessful(): bool
    {
        return $this->payment_status === config('stripe.succeeded_status');
    }
}
