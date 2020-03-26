<?php

namespace AsLong\Order\Events;

use AsLong\Order\Models\Order;

/**
 * 订单审核通过事件
 * Class OrderAudited
 * @package AsLong\Order\Events
 */
class OrderAudited
{

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

}

