<?php

namespace AsLong\Order\Facades;

use Illuminate\Support\Facades\Facade;

class Order extends Facade
{

    protected static function getFacadeAccessor()
    {
        return \AsLong\Order\Order::class;
    }

}
