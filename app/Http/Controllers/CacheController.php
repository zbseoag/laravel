<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Cache\LockTimeoutException;

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



        $lock = Cache::lock('foo', 10);
        if ($lock->get()) {
            // 获取锁定10秒...
            $lock->release();
        }

        Cache::lock('foo')->get(function () {
            // 获取无限期锁并自动释放
        });

        $lock = Cache::lock('foo', 10);
        try {
            $lock->block(5);

            // 等待最多5秒后获取的锁...
        } catch (LockTimeoutException $e) {
            // 无法获取锁...
        } finally {
            optional($lock)->release();
        }

        Cache::lock('foo', 10)->block(5, function () {
            // 等待最多5秒后获取的锁...
        });

    }




}
