<?php

namespace AsLong\Order\Events;

use AsLong\Order\Models\Order;
use AsLong\Order\Models\Refund;

/**
 * 订单申请退款
 */
class RefundApplied
{

    public $order;

    public $refund;

    public function __construct(Order $order, Refund $refund)
    {
        $this->order  = $order;
        $this->refund = $refund;
    }
}
