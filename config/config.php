<?php

return [

    /**
     * 订单编号规则
     */
    'orderid' => [
        'length' => 20,
        'prefix' => '',
    ],

    'user_model' => App\Models\User::class,

    'seller_model' => App\Models\User::class,
];
