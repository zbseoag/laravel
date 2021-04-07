<?php
namespace App\Http\Controllers;

class RedisController {

    /**
     * https://github.com/nrk/predis/wiki/Connection-Parameters
     */
    public function config(){
        [
            'redis' => [
                'client' => env('REDIS_CLIENT', 'phpredis'),
                'default' => [
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'password' => env('REDIS_PASSWORD', null),
                    'port' => env('REDIS_PORT', 6379),
                    'database' => env('REDIS_DB', 0),
                    'read_write_timeout' => 60,
                ],

                'cache' => [
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'password' => env('REDIS_PASSWORD', null),
                    'port' => env('REDIS_PORT', 6379),
                    'database' => env('REDIS_CACHE_DB', 1),
                ],

            ],
        ];

        //多台
        [

            'redis' => [

                'client' => env('REDIS_CLIENT', 'phpredis'),

                'default' => [
                    'url' => 'tcp://127.0.0.1:6379?database=0',
                ],

                'cache' => [
                    'url' => 'tls://user:password@127.0.0.1:6380?database=1',
                ],

            ],
        ];

        [
            'redis' => [

                'client' => env('REDIS_CLIENT', 'phpredis'),

                'default' => [
                    'scheme' => 'tls', //TLS/SSL 加密
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                    'password' => env('REDIS_PASSWORD', null),
                    'port' => env('REDIS_PORT', 6379),
                    'database' => env('REDIS_DB', 0),
                ],

            ],
        ];

        //集群配置
        [
            'redis' => [
                'client' => env('REDIS_CLIENT', 'phpredis'),
                'clusters' => [
                    'default' => [
                        [
                            'host' => env('REDIS_HOST', 'localhost'),
                            'password' => env('REDIS_PASSWORD', null),
                            'port' => env('REDIS_PORT', 6379),
                            'database' => 0,
                        ],
                    ],
                ],

            ],
        ];


        [
            'redis' => [
                'client' => env('REDIS_CLIENT', 'phpredis'),
                'options' => [
                    'cluster' => env('REDIS_CLUSTER', 'redis'),
                    'password' => env('REDIS_CLUSTER_PWD', null),
                    //当phpredis版本大于4.3.0时，在这里配置redis原生集群密码
                ],

                'clusters' => [
                    // ...
                ],

            ],
        ];


        //如果您打算将 PhpRedis 扩展名与 Redis Facade 别名一起使用，则应该将其重命名为其他名称, 以保证不与 Redis 类产生命名冲突。在 app.php 配置文件的别名部分中执行此操作。
        //'RedisManager' => Illuminate\Support\Facades\Redis::class,
    }

    public function index(){

        $user = Redis::get('user:profile:'.$id);
        Redis::set('name', 'Taylor');
        $values = Redis::lrange('names', 5, 10);
        $values = Redis::command('lrange', ['name', 5, 10]);

        $redis = Redis::connection();
        $redis = Redis::connection('my-connection');

        Redis::pipeline(function ($pipe) {
            for ($i = 0; $i < 1000; $i++) {
                $pipe->set("key:$i", $i);
            }
        });

        //发布订阅
        Redis::psubscribe(['*'], function ($message, $channel) {
            echo $message;
        });

        Redis::psubscribe(['users.*'], function ($message, $channel) {
            echo $message;
        });


    }

}
