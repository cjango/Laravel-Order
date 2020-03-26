<?php

namespace AsLong\Order;

use AsLong\Cart\Exceptions\CartException;
use AsLong\Order\Exceptions\OrderException;
use AsLong\Order\Models\Order;
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

    /**
     * Notes: 创建退款单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 4:34 下午
     * @param Order $order 需要退款的订单
     * @param array $items 退款项目
     * @param float|null $total 申请退款金额
     */
    public function create(Order $order, array $items, float $total = null)
    {
        if (empty($items)) {
            throw new CartException('无法创建无内容的订单');
        }

        if (!$order->canRefund()) {
            throw new OrderException('订单状态不可退款');
        }

        $maxAmount   = 0;
        $refundItems = [];
        //判断最大可退数量
        foreach ($items as $item) {
            $detail = OrderDetail::find($item['item_id']);
            if ($item['number'] <= 0) {
                throw new OrderException('【' . $detail->item->getTitle() . '】退货数量必须大于0');
            }
            if ($item['number'] > $detail->max_refund) {
                throw new OrderException('【' . $detail->item->getTitle() . '】超过最大可退数量');
            }
            $maxAmount     += $detail->price * $item['number'];
            $refundItems[] = new RefundItem(['detail' => $detail, 'number' => $item['number']]);
        }

        // 自动计算退款金额
        if (is_null($total)) {
            $total = $maxAmount;
        } elseif (!in_array($order->getOrderStatus('deliver'), [0, 1, 4]) && $total > $maxAmount) {
            throw new OrderException('超过最大可退金额');
        }

        DB::transaction(function () use ($order, $total, $refundItems) {
            // 判断退款金额
            if (in_array($order->getOrderStatus('deliver'), [0, 1, 4, 6]) && $order->amount == $total) {
                $total = $order->total;
                // 如果是未发货，无需发货，未收到的，直接退全款
                $order->setOrderStatus('pay', 4);
            } elseif ($order->total == $total) {
                $order->setOrderStatus('pay', 4);
            } elseif ($order->amount == $total) {
                $order->setOrderStatus('pay', 2);
            } else {
                $order->setOrderStatus('pay', 3);
            }
            if (in_array($order->getOrderStatus('deliver'), [0, 1, 8])) {
                $order->setOrderStatus('deliver', 6);
            }
            $order->state = Order::REFUND_APPLY;
            $order->save();
            $refund = $order->refund()->create([
                'refund_total' => $total,
                'state'        => Refund::REFUND_APPLY,
            ]);
            $refund->items()->saveMany($refundItems);
            event(new RefundApplied($order, $refund));
        });

    }

}
