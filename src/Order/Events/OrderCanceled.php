<?php

namespace AsLong\Order\Events;

use AsLong\Order\Models\Order;

/**
 * 订单支付完成事件
 */
class OrderCanceled
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
