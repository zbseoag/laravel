<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome'); });

Route::get('/user', [\App\Http\Controllers\UserController::class, 'index']);

app('router')->namespace('\App\Http\Controllers')->group(function (\Illuminate\Routing\Router $router){

    $router->group(['prefix'=>'test'], function ($router) {
        $router->any('index','TestController@index')->name('test.index');

    });

});
