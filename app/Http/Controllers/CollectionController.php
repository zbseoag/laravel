<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index()
    {
        Collection::make();
        Collection::macro();
        $collection = collect([1,2,3, null]);
        $collection->map(function($name){
            return strtoupper($name);
        })
        ->reject(function($name){
            return emtpy($name);
        });

        //添加一个 toUpper 方法
        Collection::macro('toUpper', function(){
            return $this->map(function($value){
                return Str::upper($value);
            });
        });

        $collection->all();
        collect([['age'=>23], ['age'=>30]])->avg('age');

        $collection->chunk(5);

        collect(str_split('AABBCCCD'))->chunkWhile(function ($current, $key, $chunk) {
            return $current === $chunk->last();
        });
        // [['A', 'A'], ['B', 'B'], ['C', 'C', 'C'], ['D']]

        //多维转一维
        collect([[1, 2, 3], [4, 5, 6], [7, 8, 9]])->collapse();// [1, 2, 3, 4, 5, 6, 7, 8, 9]
        collect(['name', 'age'])->combine(['Tom', 29]);

        $collection->collect();//返回新实例

        //将 懒集合 转换为标准的 Collection 实例
        LazyCollection::make(function () {
            yield 1;
            yield 2;
            yield 3;
        })->collect();


        $collection->concat(['Jane Doe'])->concat(['name' => 'Johnny Doe']);
        $collection->contains('Desk');//是否包含
        $collection->contains('product', '=', 'Bookcase');
        $collection->contains(function ($value, $key) {
            return $value > 5;
        });
        //严格比较用 containsStrict

        $collection->count();
        $collection->countBy();//集合中每个值的出现次数

        // ['gmail.com' => 2, 'yahoo.com' => 1]
        collect(['alice@gmail.com', 'bob@yahoo.com', 'carlos@gmail.com'])->countBy(function ($email) {
            return substr(strrchr($email, "@"), 1);
        });

        $collection->crossJoin(['a', 'b'], ['I', 'II']);

        $collection->diff([2, 4, 6, 8]);
        $collection->diffAssoc(['color' => 'yellow', 'type' => 'fruit',]);//基于键名和值一起比较
        $collection->diffKeys(['color' => 'yellow', 'type' => 'fruit',]);//基于键名

        $collection->duplicates('keyname');//返回重复值,duplicatesStrict 以严格比较

        $collection->each(function ($item, $key) {
            if (true) return false;
        });

        collect([['John Doe', 35], ['Jane Doe', 33]])->eachSpread(function ($name, $age) {

        });

        //验证集合中的每一个元素是否通过测试
        collect([1, 2, 3, 4])->every(function ($value, $key) {
            return $value > 2;
        });

        $collection->except(['price', 'discount']);//排除，反方法是 only
        $collection->filter(function ($value, $key) {
            return $value > 2;
        });//如果没有回调函数，则移除空元素

        //第一个满足条件的元素
        collect([1, 2, 3, 4])->first(function ($value, $key) {
            return $value > 2;
        });

        $collection->firstWhere('name', '=', 'Linda');

        $collection = collect([
            ['name' => 'Sally'],
            ['school' => 'Arkansas'],
            ['age' => 28]
        ]);

        $flattened = $collection->flatMap(function ($values) {
            return array_map('strtoupper', $values);
        });// ['name' => 'SALLY', 'school' => 'ARKANSAS', 'age' => '28'];


        $collection->flatten(1);//转一维

        $collection->flip();//键与值互换
        $collection->forget('name');//直接修改原集合
        $collection->forPage(2, 3);
        $collection->get('name', 'defaultvalue');
        $collection->groupBy(function($item, $key){
            return substr($item['account'], -3);
        });
        $collection->groupBy(['a', 'b']);
        $collection->has('name');
        $collection->implode('username', ',');

        $collection->intersect(['Desk', 'Chair', 'Bookcase']);//交集
        $collection->intersectByKeys(['Desk', 'Chair', 'Bookcase']);//key的交集
        $collection->isEmpty();
        $collection->isNotEmpty();
        collect(['a', 'b', 'c'])->join(', ', ', and '); // 'a, b, and c'
        $collection->keyBy('product_id');
        $collection->keys();
        $collection->last(function($value, $key){ return $value > 3; });

        collect(['USD', 'EUR'])->mapInto(Obj::class);//通过将值传递给构造函数来创建实例 [Obj('USD'), Obj('EUR'))]
        collect([1, 2, 3, 4, 5])->map(function ($item, $key) {
            return $item * 2;
        });// [2, 4, 6, 8, 10]

        collect([1, 2, 3, 4, 5])->max();
        collect([1, 1, 2, 4])->median();//中间值
        $collection->merge(['price' => 200, 'discount' => false]);
        $collection->mergeRecursive(['product_id' => 2, 'price' => 200]);//递归的形式合并
        collect([1, 2, 3, 4, 5])->min();
        collect([1, 1, 2, 4])->mode();//众数
        $collection->nth(4, 1);//从索引为1的元素，每四个一次抽取
        $collection->only(['product_id', 'name']);
        $collection->pad(5, 0);//填充

        //根据条件把元素分成两组
        list($underThree, $equalOrAboveThree) = $collection->partition(function ($i) {
            return $i < 3;
        });

        //把集合放到回调参数中并返回回调的结果
        $collection->pipe(function ($collection) {
            return $collection->sum();
        });


        $resource = $collection->pipeInto(ResourceCollection::class);
        $resource->collection->all();

        $collection->pluck('name');

        $collection->prepend(0);
        $collection->prepend(0, 'zero');

        $collection->pop();
        $collection->push(5);
        $collection->put('price', 100);
        $collection->random(5);

        $collection->reduce(function ($carry, $item) {
            return $carry + $item;
        }, 'init');

        $collection->replace([1 => 'Victoria', 3 => 'Finn']);//键相同则覆盖
        $collection->reverse();
        $collection->search(2);
        $collection->search('4', true);
        $collection->search(function ($item, $key) {
            return $item > 5;
        });

        $collection->shift();
        $shuffled = $collection->shuffle();
        $collection = $collection->skip(4);//跳过指定数量
        $collection->skipUntil(function ($item) {
            return $item >= 3;
        });
        $collection->skipWhile(function ($item) {
            return $item <= 3;
        });

        $collection->slice(4, 2);
        $collection->sort();
        $collection->sortBy('title', SORT_NATURAL);
        $collection->values()->all();
        $collection->sortBy(function ($product, $key) {
            return count($product['colors']);
        });

        $collection->sortKeys();
        $collection->splice(2);//移除并返回指定索引开始的元素片段
        $collection->split(3);
        $collection->splitIn(3);
        $collection->sum('pages');

        Collection::times(10, function ($times) {
            return $times * 9;
        });// [9, 18, 27, 36, 45, 54, 63, 72, 81, 90]

        $collection->toArray();
        $collection->toJson();

        $collection->transform(function ($item, $key) {
            return $item * 2;
        });//改变当前集合
        $collection->union([3 => ['c'], 1 => ['b']]);
        $collection->unique();

        $collection->unless(false, function ($collection) {
            return $collection->push(5);
        });
        $collection->values();//返回键被重置为连续编号的新集合
        $collection->when(true, function ($collection) {
            return $collection->push(4);
        });
        $collection->where('deleted_at', '!=', null);
        $collection->whereBetween('price', [100, 200]);
        $collection->whereIn('price', [150, 200]);
        $collection->whereInstanceOf(User::class);

        //相对应的索引处合并数组值
        $collection->zip([100, 200]);


    }

}
