<?php

namespace AsLong\Order\Traits;

use AsLong\Order\Models\Order;

trait OrderHasScopes
{

    /**
     * Notes: 未付款订单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 2:23 下午
     * @param $query
     * @return mixed
     */
    public function scopeUnpaid($query)
    {
        return $query->whereIn('state', [Order::ORDER_INIT, Order::ORDER_UNPAY]);
    }

    /**
     * Notes: 待发货订单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 2:23 下午
     * @param $query
     * @return mixed
     */
    public function scopeUnDeliver($query)
    {
        return $query->whereIn('state', [Order::ORDER_PAID, Order::ORDER_DELIVER]);
    }

    /**
     * Notes: 已发货订单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 2:23 下午
     * @param $query
     * @return mixed
     */
    public function scopeDelivered($query)
    {
        return $query->where('state', Order::ORDER_DELIVERED);
    }

    /**
     * Notes: 已签收订单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 2:22 下午
     * @param $query
     * @return mixed
     */
    public function scopeSigned($query)
    {
        return $query->where('state', Order::ORDER_SIGNED);
    }

    /**
     * Notes: 异常状态订单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 2:22 下午
     * @param $query
     * @return mixed
     */
    public function scopeAbnormal($query)
    {
        return $query->where('state', Order::ORDER_DELIVERED);
    }

}
