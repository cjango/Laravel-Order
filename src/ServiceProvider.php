<?php

namespace AsLong\Order;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{

    /**
     * Notes: 部署时加载
     * @Author: <C.Jason>
     * @Date: 2019/11/20 11:59 上午
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/config.php' => config_path('order.php')]);
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        }
    }

    /**
     * Notes: 注册服务提供者
     * @Author: <C.Jason>
     * @Date: 2019/11/20 11:59 上午
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'order');
    }

}