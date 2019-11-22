# Laravel-Order

## 1.安装
```
$ composer require aslong/laravel-order
```
```
$ php artisan vendor:publish --provider="AsLong\Order\ServiceProvider"
```
```
$ php artisan migrate
```

## 2.订单部分
### 1.创建订单
```php
<?php
use AsLong\Order\Item;

// $user 要实实现 Authenticatable 或 int
// $address 要实实现 Addressbook

\Order::user($user)
    ->address($address)
    ->create(
        new Item(Goods::find(1), 3),
        new Item(Goods::find(2), 5),
    );

\Order::user($user)
    ->address($address)
    ->fromCart(
        $rowIds
    );
```
## 2.退款订单
