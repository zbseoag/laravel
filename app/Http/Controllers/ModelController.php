<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ModelController extends Controller
{
    public function index()
    {
        
        User::fill(['name' => 'Flight 22']);

        //查找可生成一个实例
        User::query()->firstOrNew(
            ['name' => 'Flight 10'],//查询条件
            ['delayed' => 1, 'arrival_time' => '11:30']//实例属性
        )->save();

        //查找或插入一条数据
        User::query()->firstOrCreate(
            ['name' => 'Flight 10'],//查询条件
            ['delayed' => 1, 'arrival_time' => '11:30']//实例属性值
        );

        //查找或插入一条数据
        User::query()->updateOrCreate(
            ['departure' => 'Oakland', 'destination' => 'San Diego'],
            ['price' => 99, 'discounted' => 1]
        );

        //批量更新数据
        User::query()->upsert(
            [
                ['departure' => 'Oakland', 'destination' => 'San Diego', 'price' => 99],
                ['departure' => 'Chicago', 'destination' => 'New York', 'price' => 150]
            ], //插入数据
            ['departure', 'destination'], //条件字段，一定要是插入数据中包含的字段
            ['price']//更新字段，一定要是插入数据中包含的字段
        );

        User::query()->create([
            'type' => 'shipping',
            'line_1' => '123 Example Street',
            'city' => 'Victorville',
            'state' => 'CA',
            'postcode' => '90001',
        ])->replicate()->fill(['type' => 'billing'])->save();

    }
}
