<?php

namespace AsLong\Order;

use AsLong\Address\Contracts\Addressbook;

class Order
{

    /**
     * Notes: 下单
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:36 下午
     * @param $userId
     * @param $items
     * @param Addressbook|null $address
     * @param null $remark
     */
    public function order($userId, $items, Addressbook $address = null, $remark = null)
    {

    }

    function refund()
    {

    }

}