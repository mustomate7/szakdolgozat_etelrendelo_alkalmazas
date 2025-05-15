<?php

namespace App\Dtos;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderDto
{
    public Order $order;
    public Collection $orderItems;

    public function __construct(Order $order, Collection $orderItems)
    {
        $this->order = $order;
        $this->orderItems = $orderItems;
    }
}