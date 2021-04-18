<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     * @return void
     */
    public function register(){
        //
    }

    /**
     * 引导所有应用的服务
     * @return void
     */
    public function boot(){
        //监听查询事件
        DB::listen(function ($query) {
            $query->sql;
            $query->bindings;
            $query->time;
        });

        //模型注册观察者
        //User::observe(UserObserver::class);

        //定义分页默认视图
        Paginator::defaultView('view-name');
        Paginator::defaultSimpleView('view-name');
        Paginator::useBootstrap();


        //Schema::defaultStringLength(191);
    }

}
