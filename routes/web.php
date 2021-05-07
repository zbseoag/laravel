<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome'); });
Route::get('/user/index', [\App\Http\Controllers\UserController::class, 'index']);

Route::namespace('\App\Http\Controllers')->group(function (\Illuminate\Routing\Router $router){

    $router->group(['prefix'=>'test'], function ($router) {
        $router->any('index','TestController@index')->name('test.index');
    });


});




