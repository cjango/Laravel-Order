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
```php
<?php
use AsLong\Order\Item;

$user  = User::first();
$order = \Order::user($user)->create([
    new Item(Goods::find(1), 4),
    new Item(Goods::find(2), 3),
    new Item(Goods::find(3), 2),
    new Item(Goods::find(4), 5),
    new Item(Goods::find(5), 1),
], Address::first());
```

## 2.退款订单