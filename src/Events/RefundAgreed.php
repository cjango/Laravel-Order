<?php

namespace AsLong\Order\Events;

use AsLong\Order\Models\Refund;

/**
 * 同意退款
 */
class RefundAgreed
{

    public $refund;

    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }
}
