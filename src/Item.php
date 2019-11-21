<?php

namespace AsLong\Order;

use AsLong\Order\Contracts\ShouldOrder;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Item implements Arrayable, Jsonable
{

    protected $qty;

    protected $item_type;

    protected $item_id;

    protected $price;

    /**
     * Item constructor.
     * @param ShouldOrder $item
     * @param int $qty
     */
    public function __construct(ShouldOrder $item, int $qty = 1)
    {
        $this->item_type = get_class($item);
        $this->item_id   = $item->getCartableIdentifier();
        $this->qty       = $qty;
        $this->price     = $item->getCartablePrice();
    }

    /**
     * Notes:  获取条目总价
     * @Author: <C.Jason>
     * @Date: 2019/11/21 11:03 上午
     * @return float|int
     */
    public function total()
    {
        return bcmul($this->price, $this->qty, 2);
    }

    public function toArray()
    {
        return [
            'item_type' => $this->item_type,
            'item_id'   => $this->item_id,
            'qty'       => $this->qty,
            'price'     => $this->price,
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

}
