<?php

namespace AsLong\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderLog extends Model
{

    const UPDATED_AT = null;

    protected $guarded = [];

    /**
     * Notes: 设置用户
     * @Author: <C.Jason>
     * @Date: 2019/11/22 3:51 下午
     * @param $user
     */
    public function setUserAttribute($user)
    {
        if (!is_null($user)) {
            $this->attributes['user_type'] = get_class($user) ?? null;
            $this->attributes['user_id']   = $user->id ?? 0;
        }
    }

    /**
     * Notes: 所属订单
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:50 下午
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Notes: 操作用户
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:50 下午
     * @return MorphTo
     */
    public function user(): MorphTo
    {
        return $this->morphTo();
    }

}
