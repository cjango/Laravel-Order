# Laravel-Order

## 安装
```
$ composer require aslong/laravel-order
```
```
$ php artisan vendor:publish --provider="AsLong\Order\ServiceProvider"
```
```
$ php artisan migrate
```

## 1.订单部分
### 1.创建订单
Order::order($user);
## 2.退款订单