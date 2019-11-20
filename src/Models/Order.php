<?php

namespace AsLong\Order\Models;

use AsLong\Order\Traits\OrderCando;
use AsLong\Order\Traits\OrderHasActions;
use AsLong\Order\Traits\OrderHasAttributes;
use AsLong\Order\Traits\OrderHasScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use OrderCando, OrderHasActions, OrderHasAttributes, OrderHasScopes, SoftDeletes;

    const ORDER_INIT       = 'INIT';             // 订单初始化
    const ORDER_UNPAY      = 'UNPAY';            // 待支付
    const ORDER_PAID       = 'PAID';             // 已支付
    const ORDER_DELIVER    = 'DELIVER';          // 发货处理中
    const ORDER_DELIVERED  = 'DELIVERED';        // 已发货
    const ORDER_SIGNED     = 'SIGNED';           // 已签收
    const REFUND_APPLY     = 'REFUND_APPLY';     // 申请退款
    const REFUND_AGREE     = 'REFUND_AGREE';     // 同意退款
    const REFUND_REFUSE    = 'REFUND_REFUSE';    // 拒绝退款
    const REFUND_PROCESS   = 'REFUND_PROCESS';   // 退款中
    const REFUND_COMPLETED = 'REFUND_COMPLETED'; // 退款完成
    const ORDER_CLOSED     = 'CLOSED';           // 已关闭
    const ORDER_CANCEL     = 'CANCEL';           // 取消
    const ORDER_COMPLETED  = 'COMPLETED';        // 已完成

    const CANCEL_USER   = 2; // 买家取消
    const CANCEL_SELLER = 3; // 卖家取消
    const CANCEL_SYSTEM = 4; // 系统取消

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $dates = [
        'paid_at',
    ];

    /**
     * Notes: 路由查询主键
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:43 下午
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'orderid';
    }

    /**
     * Notes: 订单初始化
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:45 下午
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->orderid = Helper::orderid(config('order.orderid.length'), config('order.orderid.prefix'));
        });

        self::updated(function ($model) {
            $model->logs()->create([
                'status' => $model->getOriginal('status', '0000') . '|' . $model->status,
                'state'  => $model->getOriginal('state') . '|' . $model->state,
            ]);
        });
    }

    /**
     * Notes: 关联所属用户
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:51 下午
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('order.user_model'))->withDefault();
    }

    /**
     * Notes:
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:51 下午
     * @return BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(config('order.seller_model'))->withDefault();
    }

    /**
     * Notes: 订单详情
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:52 下午
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Notes: 订单物流
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:52 下午
     * @return HasOne
     */
    public function express()
    {
        return $this->hasOne(OrderExpress::class);
    }

    /**
     * Notes: 订单日志
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:53 下午
     * @return HasMany
     */
    public function logs()
    {
        return $this->hasMany(OrderLog::class);
    }

    /**
     * Notes: 退款单
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:54 下午
     * @return HasMany
     */
    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

}