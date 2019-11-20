<?php

namespace AsLong\Order\Traits;

use AsLong\Order\Models\Order;

trait UserHasOrders
{

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}