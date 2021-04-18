<?php

/**
 *生成
 * php artisan make:seeder UserSeeder
 *
 * 运行（默认运行 DatabaseSeeder 类，使用 --class 选项来指定 seeder 类）
 * php artisan db:seed --class=UserSeeder --force
 * 重新创建数据
 * php artisan migrate:fresh --seed
 *
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    /**
     * 执行数据库填充
     * @return void
     */
    public function run(){
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        ]);
        //使用模型工厂 https://learnku.com/docs/laravel/8.x/database-testing#writing-factories
        User::factory()->times(50)->hasPosts(1)->create();

        //调用其它 Seeders
        $this->call([UserSeeder::class, PostSeeder::class, CommentSeeder::class,]);


    }

}
