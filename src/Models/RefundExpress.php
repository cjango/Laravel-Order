<?php

namespace AsLong\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefundExpress extends Model
{

    protected $guarded = [];

    protected $dates   = [
        'deliver_at',
        'receive_at',
    ];

    /**
     * Notes: 所属退款单
     * @Author: <C.Jason>
     * @Date: 2019/11/22 4:25 下午
     * @return BelongsTo
     */
    public function refund(): BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }

}
