<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;


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

        QueryBuilder::macro('sql', function(){
            return array_reduce($this->getBindings(), function($sql, $binding){
                return preg_replace('/\?/', is_string($binding) ? "'".$binding."'"  : $binding, $sql, 1);
            }, $this->toSql());
        });

        EloquentBuilder::macro('sql', function(){ return $this->getQuery()->sql(); });
        EloquentBuilder::macro('dd', function(){ dd($this->getQuery()->sql()); });
        EloquentBuilder::macro('dump', function(){ dump($this->getQuery()->sql()); });

    }


}
