<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


//方法将消息发布到频道 RedisSubscribe
Route::get('publish', function(){
    Redis::publish('test-channel', json_encode(['foo' => 'bar']));

});
