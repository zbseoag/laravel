<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        DB::listen(function($query){
//            p($query->sql);
//            // $query->bindings
//            // $query->time
//        });
        require base_path('app/Tools/Mixin.php');
    }

}
