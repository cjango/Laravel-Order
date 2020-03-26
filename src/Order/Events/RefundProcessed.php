<?php

namespace AsLong\Order\Events;

use AsLong\Order\Models\Refund;

/**
 * 退款中事件，可选择在此处切入退款功能
 */
class RefundProcessed
{

    public $refund;

    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }
}
