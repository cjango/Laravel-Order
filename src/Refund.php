<?php

namespace AsLong\Order;

use AsLong\Order\Exceptions\OrderException;
use Illuminate\Contracts\Auth\Authenticatable;

class Refund
{

    public function user($user)
    {
        if ($user instanceOf Authenticatable) {
            $this->user = $user->getAuthIdentifier();
        } elseif (is_numeric($user)) {
            $this->user = $user;
        } else {
            throw new OrderException('非法用户');
        }

        return $this;
    }

    /**
     * Notes: 设置订单备注信息
     * @Author: <C.Jason>
     * @Date: 2019/11/22 10:38 上午
     * @param string $remark
     * @return $this
     */
    public function remark(string $remark)
    {
        $this->remark = $remark;

        return $this;
    }

}
