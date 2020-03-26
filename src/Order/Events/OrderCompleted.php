<?php

namespace AsLong\Order\Events;

use AsLong\Order\Models\Order;

/**
 * 订单完毕
 */
class OrderCompleted
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
