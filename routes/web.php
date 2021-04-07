<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//方法将消息发布到频道 RedisSubscribe
Route::get('publish', function(){
    Redis::publish('test-channel', json_encode(['foo' => 'bar']));

});
