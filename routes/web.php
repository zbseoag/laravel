<?php
use Illuminate\Support\Facades\Route;

Route::any('/', function () {return view('welcome'); });
Route::any('/user/index', [\App\Http\Controllers\UserController::class, 'index']);

Route::namespace('\App\Http\Controllers')->group(function($router){

    $prefix = 'index';
    $router->group(['prefix' => $prefix], function ($router) use($prefix){
        $router->any('/','IndexController@index')->name($prefix . '.index');
        $router->any('get','IndexController@get')->name($prefix . '.get');
        $router->any('post','IndexController@post')->name($prefix . '.post');
    });

    $prefix = 'test';
    $router->group(['prefix'=>'test'], function ($router) use($prefix){
        $router->any('index','TestController@index')->name($prefix . '.index');

    });

});




