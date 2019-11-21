<?php

namespace AsLong\Order\Models;

use AsLong\Order\Traits\RefundCando;
use AsLong\Order\Traits\RefundHasActions;
use AsLong\Order\Utils\Helper;
use Encore\Admin\Form\Field\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{

    use RefundHasActions, RefundCando, SoftDeletes;

    const REFUND_APPLY     = 'REFUND_APPLY';     // 申请退款
    const REFUND_AGREE     = 'REFUND_AGREE';     // 同意退款
    const REFUND_REFUSE    = 'REFUND_REFUSE';    // 拒绝退款
    const REFUND_PROCESS   = 'REFUND_PROCESS';   // 退款中
    const REFUND_COMPLETED = 'REFUND_COMPLETED'; // 退款完成

    protected $table   = 'order_refunds';

    protected $guarded = [];

    protected $dates   = [
        'refunded_at',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->orderid = Helper::orderid(config('aslong_order.refund_orderid.length'), config('aslong_order.refund_orderid.prefix'));
        });
    }

    /**
     * 所属订单
     * @Author:<C.Jason>
     * @Date:2018-10-19T13:45:04+0800
     * @return Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * 退款单详情
     * @Author:<C.Jason>
     * @Date:2018-10-19T13:45:26+0800
     * @return OrderRefundItem
     */
    public function items(): HasMany
    {
        return $this->hasMany(RefundItem::class);
    }

    /**
     * 退款单物流
     * @Author:<C.Jason>
     * @Date:2018-10-19T10:36:03+0800
     * @return RefundExpress
     */
    public function express(): HasOne
    {
        return $this->hasOne(RefundExpress::class);
    }

    /**
     * 获取退款状态 $this->state_text
     * @Author:<C.Jason>
     * @Date:2018-10-19T10:56:24+0800
     * @return string
     */
    protected function getStateTextAttribute(): string
    {
        switch ($this->state) {
            case self::REFUND_APPLY:
                $state = '退款申请中';
                break;
            case self::REFUND_AGREE:
                $state = '同意退款';
                break;
            case self::REFUND_PROCESS:
                $state = '退款中';
                break;
            case self::REFUND_COMPLETED:
                $state = '退款完毕';
                break;
            case self::REFUND_REFUSE:
                $state = '拒绝退款';
                break;
            default:
                $state = '未知状态';
                break;
        }

        return $state;
    }

}
