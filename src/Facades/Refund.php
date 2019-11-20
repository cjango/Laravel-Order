<?php

namespace AsLong\Order\Facades;

use Illuminate\Support\Facades\Facade;

class Refund extends Facade
{

    protected static function getFacadeAccessor()
    {
        return \AsLong\Order\Refund::class;
    }

}