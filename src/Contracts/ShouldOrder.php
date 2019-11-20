<?php

namespace AsLong\Order\Contracts;

use AsLong\Cart\Contracts\ShouldCart;

/**
 * 可购买商品 契约
 */
interface ShouldOrder extends ShouldCart
{

    /**
     * Notes: 获取商品名称
     * @Author: <C.Jason>
     * @Date: 2019/11/20 3:20 下午
     * @return mixed
     */
    public function getOrderableName();

    /**
     * Notes: 获取商品库存
     * @Author: <C.Jason>
     * @Date: 2019/11/20 3:21 下午
     * @param null $options
     * @return mixed
     */
    public function getOrderableStock($options = null);

    /**
     * Notes: 扣除库存方法
     * @Author: <C.Jason>
     * @Date: 2019/11/20 3:21 下午
     * @param $stock
     * @param null $options
     * @return mixed
     */
    public function deductStock($stock, $options = null);

    /**
     * Notes: 增加库存方法
     * @Author: <C.Jason>
     * @Date: 2019/11/20 3:21 下午
     * @param $stock
     * @param null $options
     * @return mixed
     */
    public function addStock($stock, $options = null);

}
