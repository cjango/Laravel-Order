<?php

namespace AsLong\Order\Traits;

use AsLong\Cart\Triats\Cartable;

trait Orderable
{

    use Cartable;

    /**
     * Notes: 获取商品名称
     * @Author: <C.Jason>
     * @Date: 2019/11/21 10:36 上午
     * @return mixed
     */
    public function getOrderableName()
    {
        return $this->name;
    }

    /**
     * Notes: 获取商品库存
     * @Author: <C.Jason>
     * @Date: 2019/11/20 3:21 下午
     * @param null $options
     * @return mixed
     */
    public function getOrderableStock($options = null)
    {
        return $this->stocks;
    }

    /**
     * Notes: 扣除库存方法
     * @Author: <C.Jason>
     * @Date: 2019/11/21 10:39 上午
     * @param int $stock
     * @param null $options
     */
    public function deductStock($stock = 1, $options = null)
    {
        $this->decrement('stocks', $stock);
    }

    /**
     * Notes: 增加库存方法
     * @Author: <C.Jason>
     * @Date: 2019/11/21 10:39 上午
     * @param int $stock
     * @param null $options
     */
    public function addStock($stock = 1, $options = null)
    {
        $this->increment('stocks', $stock);
    }

}
