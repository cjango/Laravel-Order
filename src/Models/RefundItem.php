<?php

namespace AsLong\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RefundItem extends Model
{

    const UPDATED_AT = null;

    protected $guarded = [];

    /**
     * Notes: 所属退款单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 4:15 下午
     * @return
     */
    public function refund(): BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }

    /**
     * Notes: 所属订单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 4:16 下午
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Notes: 所属订单详情
     * @Author: <C.Jason>
     * @Date: 2019/11/22 4:16 下午
     * @return BelongsTo
     */
    public function detail(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Notes: 商品详情
     * @Author: <C.Jason>
     * @Date: 2019/11/22 4:16 下午
     * @return MorphTo
     */
    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Notes: 获取单个商品总价
     * @Author: <C.Jason>
     * @Date: 2019/11/22 4:16 下午
     * @return string
     */
    public function getTotalAttribute(): string
    {
        return bcmul($this->price, $this->qty, 2);
    }

    /**
     * Notes: 设置退款单详情使用
     * @Author: <C.Jason>
     * @Date: 2019/11/22 4:17 下午
     * @param $detail
     */
    public function setDetailAttribute($detail)
    {
        $this->attributes['order_id']        = $detail->order_id;
        $this->attributes['order_detail_id'] = $detail->id;
        $this->attributes['item_id']         = $detail->item_id;
        $this->attributes['item_type']       = $detail->item_type;
        $this->attributes['price']           = $detail->price;
    }

}
