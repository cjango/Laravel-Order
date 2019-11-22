<?php

namespace AsLong\Order;

use AsLong\Address\Contracts\Addressbook;
use AsLong\Cart\Exceptions\CartException;
use AsLong\Order\Exceptions\OrderException;
use AsLong\Order\Models\Order as OrderModel;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Order
{

    /**
     * @var int
     */
    protected $user;

    /**
     * @var float
     */
    protected $total;

    /**
     * @var Addressbook
     */
    protected $address;

    /**
     * @var array
     */
    protected $items;

    /**
     * @var string
     */
    protected $remark;

    /**
     * Notes: 设置当前用户
     * @Author: <C.Jason>
     * @Date: 2019/11/21 10:31 上午
     * @param $user
     * @return $this
     */
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
     * Notes: 设置订单收货地址
     * @Author: <C.Jason>
     * @Date: 2019/11/22 10:40 上午
     * @param Addressbook $address
     * @return $this
     */
    public function address(Addressbook $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Notes: 创建订单
     * @Author: <C.Jason>
     * @Date: 2019/11/21 10:42 上午
     * @param array $items
     * @param Addressbook|null $address
     * @param string|null $remark
     */
    public function create(array $items)
    {
        if (empty($items)) {
            throw new CartException('无法创建无内容的订单');
        }

        if (!is_numeric($this->user)) {
            throw new CartException('必须先设置订单用户');
        }

        $this->items = new Collection($items);

        $splits = $this->splitOrderBySeller($items);

        DB::beginTransaction();

        try {
            foreach ($splits as $split) {
                $orders[] = $this->createOne($split);
            }

            DB::commit();
            $result = new Collection($orders);

            $result->total = $this->total();

            return $result;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new OrderException($exception->getMessage());
        }
    }

    /**
     * Notes: 按照商户，对订单进行分组
     * @Author: <C.Jason>
     * @Date: 2019/11/21 6:00 下午
     * @return mixed
     */
    protected function splitOrderBySeller()
    {
        return $this->items->groupBy('seller_id')->map(function ($items, $key) {
            $items->amount = $items->reduce(function ($total, $item) {
                return $total + $item->total();
            });;
            $items->qty = $items->reduce(function ($qty, $item) {
                return $qty + $item->qty;
            });;
            $items->seller_id = $key;

            return $items;
        });
    }

    /**
     * Notes: 创建一条订单记录
     * @Author: <C.Jason>
     * @Date: 2019/11/22 10:23 上午
     * @param $split
     * @param null $remark
     */
    protected function createOne($split, $remark = null)
    {
        $order = OrderModel::create([
            'seller_id' => $split->seller_id,
            'user_id'   => $this->user,
            'amount'    => $split->amount,
            'freight'   => 0,
            'remark'    => $this->remark,
        ]);

        foreach ($split as $item) {
            $order->items()->create($item->toArray());
        }

        if ($this->address instanceof Addressbook) {
            $this->setOrderAddress($order, $this->address);
        }

        return $order;
    }

    /**
     * Notes: 计算订单总价格
     * @Author: <C.Jason>
     * @Date: 2019/11/21 11:17 上午
     * @return int|string
     */
    public function total()
    {
        $this->total = 0;
        foreach ($this->items as $item) {
            $this->total = bcadd($this->total, $item->total(), 2);
        }

        return $this->total;
    }

    /**
     * Notes: 设置订单收货地址
     * @Author: <C.Jason>
     * @Date: 2019/11/21 4:29 下午
     * @param $order
     */
    protected function setOrderAddress($order, $address)
    {
        $order->express()->create([
            'name'        => $address->getName(),
            'mobile'      => $address->getMobile(),
            'province_id' => $address->getProvinceId(),
            'city_id'     => $address->getCityId(),
            'district_id' => $address->getDistrictId(),
            'address'     => $address->getAddress(),
        ]);
    }

    public function __get($attr)
    {
        switch ($attr) {
            case 'total':
                return $this->total();
                break;
        }

        return null;
    }

    /**
     * Notes: 从购物车创建订单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 10:23 上午
     * @param $userId
     */
    public function fromCart($rowIds)
    {

    }

}
