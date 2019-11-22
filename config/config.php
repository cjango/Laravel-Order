<?php

return [

    /**
     * 订单编号规则
     */
    'orderid' => [
        'length' => 20,
        'prefix' => '',
    ],

    'refund_orderid' => [
        'length' => 20,
        'prefix' => 'R',
    ],

    'user_model' => App\Models\User::class,

    'seller_model' => App\Models\User::class,

    'admin_guard' => 'admin',

    /**
     * 订单自动审核
     */
    'auto_audit'  => true,
];
