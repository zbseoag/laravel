<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


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
