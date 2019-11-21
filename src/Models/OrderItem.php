<?php

namespace AsLong\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{

    const UPDATED_AT = null;

    protected $guarded = [];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Notes: 所属商品
     * @Author: <C.Jason>
     * @Date: 2019/11/21 1:08 下午
     * @return MorphTo
     */
    public function item(): MorphTo
    {
        return $this->morphTo();
    }

}
