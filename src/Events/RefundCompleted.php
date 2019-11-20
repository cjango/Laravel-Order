<?php

namespace AsLong\Order\Events;

use AsLong\Order\Models\Refund;

/**
 * 退款完成事件
 */
class RefundCompleted
{

    public $refund;

    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }
}
