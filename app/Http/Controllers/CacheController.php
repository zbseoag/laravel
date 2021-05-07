<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheController extends Controller
{
    public function cinfig()
    {
        $file = 'config/cache.php';

        Cache::store('redis')->put('key', 'baz', 600); // 10 Minutes
        Cache::get('key', 'default');
        //从数据库或其他外部服务中获取默认值
        Cache::get('key', function () {
            return DB::table()->get();
        });
    }


    public function index()
    {
        Cache::has('key');
        Cache::increment('key', 2);
        Cache::decrement('key', 3);
        //如果缓存中不存在你想要的数据时，则传递给 remember 方法的 闭包 将被执行
        Cache::remember('user', 10, function(){
            return DB::table('user')->get();
        });
        Cache::rememberForever('user', function(){
            return DB::table()->get();
        });
        Cache::pull('key');//获取并删除
        Cache::put('key', 'value', 10);
        Cache::put('key', 'value', now()->addMinutes(20));
        Cache::add('key', 'value', 10);
        Cache::forever('key', 'value');
        Cache::forget('key');
        Cache::put('key', 'value', 0);
        Cache::flush();//清空

        //访问被打上标签的缓存数据
        Cache::tags(['people', 'artists'])->put('John', 'johnn abc', 10);
        Cache::tags(['people', 'artists'])->get('John');
        Cache::tags(['people', 'authors'])->flush();
        Cache::tags('authors')->flush();


        $lock = Cache::lock('foo', 10);

        if ($lock->get()) {
            $lock->release();
        }


    }




}
