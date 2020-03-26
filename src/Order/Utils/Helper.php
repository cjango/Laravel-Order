<?php

namespace AsLong\Order\Utils;

class Helper
{

    /**
     * Notes: 订单号生成器
     * @Author: <C.Jason>
     * @Date: 2019/11/20 1:42 下午
     * @param int $length
     * @param string $prefix
     * @return string
     */
    public static function orderid($length = 20, $prefix = '')
    {
        if ($length > 30) {
            $length = 30;
        }
        $fixed = $length - 12;
        if (strlen($prefix) >= $fixed) {
            $prefix = substr($prefix, 0, $fixed);
        }

        $code = date('ymdHis') . sprintf("%0" . $fixed . "d", mt_rand(0, pow(10, $fixed) - 1));
        if (!empty($prefix)) {
            $code = $prefix . substr($code, 0, $length - strlen($prefix));
        }

        return $code;
    }

}
