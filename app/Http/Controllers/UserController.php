<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller {

    public function index(){

        $flights = App\Models\Flight::all();
        foreach ($flights as $flight) {
            echo $flight->name;
        }

        $flights = User::where('active', 1)->orderBy('name', 'desc')->take(10)->get();

        $flight = App\Models\Flight::where('number', 'FR 900')->first();
        $freshFlight = $flight->fresh(); //重新从数据库中检索,现有的模型实例不受影响

        $flight = App\Models\Flight::where('number', 'FR 900')->first();
        $flight->number = 'FR 456';
        $flight->refresh();//重新赋值现有模型
        $flight->number; // "FR 900"

        //过滤已经取消的
        $flights = $flights->reject(function ($flight) {
            return $flight->cancelled;
        });

        Flight::chunk(200, function ($flights) {
            foreach ($flights as $flight) {

            }
        });


        Flight::where('departed', true)->chunkById(200, function ($flights) {
            $flights->each->update(['departed' => false]);
        });

        foreach (Flight::where('foo', 'bar')->cursor() as $flight) {

        }

        $users = App\Models\User::cursor()->filter(function ($user) {
            return $user->id > 500;
        });

        foreach ($users as $user) {
            echo $user->id;
        }



        return App\Models\Destination::addSelect(['last_flight' => App\Models\Flight::select('name')
            ->whereColumn('destination_id', 'destinations.id')
            ->orderBy('arrived_at', 'desc')
            ->limit(1)
        ])->get();

        //根据子查询进行排序
        return Destination::orderByDesc(
            Flight::select('arrived_at')
                ->whereColumn('destination_id', 'destinations.id')
                ->orderBy('arrived_at', 'desc')
                ->limit(1)
        )->get();

        // 通过主键查找一个模型...
        $flight = App\Models\Flight::find(1);

        // 查找符合查询条件的首个模型...
        $flight = App\Models\Flight::where('active', 1)->first();

        // 查找符合查询条件的首个模型的快速实现...
        $flight = App\Models\Flight::firstWhere('active', 1);

        $flights = App\Models\Flight::find([1, 2, 3]);


        $model = App\Models\Flight::where('legs', '>', 100)->firstOr(function(){

        });

        $model = App\Models\Flight::where('legs', '>', 100)->firstOr(['id', 'legs'], function () {

        });

        $model = App\Models\Flight::findOrFail(1);
        $model = App\Models\Flight::where('legs', '>', 100)->firstOrFail();

        Route::get('/api/flights/{id}', function($id){
            return App\Models\Flight::findOrFail($id);
        });

        $count = App\Models\Flight::where('active', 1)->count();
        $max = App\Models\Flight::where('active', 1)->max('price');

    }

    public function store(Request $request){

        // 验证请求
        $flight = new Flight;
        $flight->name = $request->name;
        $flight->save();

        $flight = App\Models\Flight::find(1);
        $flight->name = 'New Flight Name';
        $flight->save();

        App\Models\Flight::where('active', 1)->where('destination', 'San Diego')->update(['delayed' => 1]);

        $user = User::create([
            'first_name' => 'Taylor',
            'title' => 'Developer',
        ]);
        $user->title = 'Painter';
        $user->isDirty(); // true
        $user->isDirty('title'); // true
        $user->isClean('first_name'); // true

        $user->save();
        $user->wasChanged(); // true
        $user->wasChanged('title'); // true
        $user->wasChanged('first_name'); // false

        $user = User::find(1);
        $user->name = "tom";
        $user->getOriginal('name'); //数据原始值
        $user->getOriginal(); // 原始属性数组

        $flight = App\Models\Flight::create(['name' => 'Flight 10']);
        $flight->fill(['name' => 'Flight 22']);


        // 通过 name 检索航班，不存在则创建
        $flight = App\Models\Flight::firstOrCreate(['name' => 'Flight 10']);

        // 通过 name 检索航班，或使用 name 和 delayed 和 arrival_time 创建
        $flight = App\Models\Flight::firstOrCreate(
            ['name' => 'Flight 10'],
            ['delayed' => 1, 'arrival_time' => '11:30']
        );

        // 通过 name 检索航班，不存在则创建一个实例
        $flight = App\Models\Flight::firstOrNew(['name' => 'Flight 10']);

        //通过 name 检索航班，或使用 name 和 delayed 和 arrival_time 创建一个模型实例...
        $flight = App\Models\Flight::firstOrNew(
            ['name' => 'Flight 10'],
            ['delayed' => 1, 'arrival_time' => '11:30']
        );

        // 如果有从奥克兰到圣地亚哥的航班，则价格定为 99 美元...
        // 如果没匹配到存在的模型，则创建一个
        $flight = App\Models\Flight::updateOrCreate(
            ['departure' => 'Oakland', 'destination' => 'San Diego'],
            ['price' => 99, 'discounted' => 1]
        );


        //第一个参数是由要插入或更新的值组成
        //第二个参数列出相应表中惟一标识记录的列
        //第三个也是最后一个参数是一个列数组，即如果数据库中已经存在匹配的记录，应该被更新的列
        App\Models\Flight::upsert([
            ['departure' => 'Oakland', 'destination' => 'San Diego', 'price' => 99],
            ['departure' => 'Chicago', 'destination' => 'New York', 'price' => 150]
        ], ['departure', 'destination'], ['price']);

        $flight = App\Models\Flight::find(1);
        $flight->delete();

        App\Models\Flight::destroy(1, 2, 3);
        App\Models\Flight::destroy([1, 2, 3]);
        App\Models\Flight::destroy(collect([1, 2, 3]));
        $deletedRows = App\Models\Flight::where('active', 0)->delete();

        //是否被删除
        if ($flight->trashed()) {

        }

        $flights = App\Models\Flight::withTrashed()->where('account_id', 1)->get();//查询结果包含软删除的数据
        $flight->history()->withTrashed()->get();
        $flights = App\Models\Flight::onlyTrashed()->where('airline_id', 1)->get();
        $flight->restore(); //恢复软删除

        App\Models\Flight::withTrashed()->where('airline_id', 1)->restore();
        $flight->history()->restore();

        //永久删除单个模型实例
        $flight->forceDelete();
        //永久删除所有关联模型
        $flight->history()->forceDelete();

        //复制模型
        $shipping = App\Models\Address::create([
            'type' => 'shipping',
            'line_1' => '123 Example Street',
            'city' => 'Victorville',
            'state' => 'CA',
            'postcode' => '90001',
        ]);

        $billing = $shipping->replicate()->fill([
            'type' => 'billing'
        ]);

        $billing->save();

        //快速校验两个模型是否拥有相同的主键、表和数据库连接
        if ($post->is($Post2)) {

        }

        //当使用 belongsTo、hasOne、morphTo 和 morphOne 关系时，is 方法也可用。
        if ($post->author()->is($user)) {

        }

        //禁用事件
        $user = User::withoutEvents(function () {
            User::findOrFail(1)->delete();
            return User::find(2);
        });

        $user = User::findOrFail(1);
        $user->name = 'Victoria Faith';
        $user->saveQuietly();//无事件的单个模型保存


    }


}
