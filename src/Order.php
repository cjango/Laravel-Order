<?php

namespace AsLong\Order;

use AsLong\Address\Contracts\Addressbook;
use AsLong\Cart\Exceptions\CartException;
use AsLong\Order\Exceptions\OrderException;
use AsLong\Order\Models\Order as OrderModel;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class Order
{

    protected $user;

    protected $total;

    protected $addressbook;

    protected $items;

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
     * Notes: 创建订单
     * @Author: <C.Jason>
     * @Date: 2019/11/21 10:42 上午
     * @param array $items
     * @param Addressbook|null $address
     * @param string|null $remark
     */
    public function create(array $items, Addressbook $address = null, string $remark = null)
    {
        if (empty($items)) {
            throw new CartException('无法创建无内容的订单');
        }

        $this->items = $items;

        $this->addressbook = $address;

        DB::beginTransaction();

        try {
            $order = OrderModel::create([
                'user_id' => $this->user,
                'amount'  => 123,
                'freight' => 0,
                'remark'  => $remark,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item->toArray());
            }

            if ($address instanceof Addressbook) {
                $order->express()->create([
                    'name'        => $address->getName(),
                    'mobile'      => $address->getMobile(),
                    'province_id' => $address->getProvinceId(),
                    'city_id'     => $address->getCityId(),
                    'district_id' => $address->getDistrictId(),
                    'address'     => $address->getAddress(),
                ]);
            }

            DB::commit();

            return $this;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new OrderException($exception->getMessage());
        }
    }

    /**
     * Notes: 计算当前总价格
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

    public function address()
    {
        if ($this->addressbook instanceof Addressbook) {
            return $this->addressbook->getFullAddress();
        } else {
            return null;
        }
    }

    public function __get($attr)
    {
        switch ($attr) {
            case 'total':
                return $this->total();
                break;
            case 'address':
                return $this->address();
                break;
        }

        return null;
    }

    public function fromCart($userId)
    {

    }

    public function refund()
    {

    }

}
