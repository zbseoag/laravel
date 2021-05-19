<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class FuncController extends Controller
{
    public function arr(){

        $array = $array1 = $array2 = [];
        Arr::accessible(new Collection);//是否数组 或 实现了 ArrayAccess

        Arr::add($array, 'key', 'value');//添加元素当元素或不存在时
        Arr::collapse($array1, $array2);//合并多个数组或将二维转成一维
        Arr::crossJoin($array1, $array2);//交叉连接给定的数组
        [$keys, $values] = Arr::divide(['key1' => 'value2', 'key2'=>'value2']);//得到键名和值

        Arr::dot(['products' => ['desk' => ['price' => 100]]]);//多维转一维，键名用 . 拼接
        Arr::except($array, ['price']);//排除指定的键名序列
        Arr::exists($array, 'name');//键是否存在
        //返回数组中满足指定条件的第一个元素
        Arr::first($array, function ($value, $key) {
            return $value >= 150;
        });

        Arr::flatten(['name' => 'Joe', 'languages' => ['PHP', 'Ruby']]);// 函数将多维数组中数组的值取出平铺为一维数组
        Arr::forget($array, 'key');//删除键值对，可以给定带点的表深度
        Arr::get($array, 'key');//获取元素,可以用点符号
        Arr::set($array, 'key', 'value');//设置指定元素的值,可以用点符号

        Arr::has($array, ['key']);//元素否存在,可以用点符号
        Arr::hasAny($array, ['key']);//是否有一个存在
        Arr::isAssoc($array);//是否为关联数组
        //返回满足条件的最后一个元素
        Arr::last($array, function ($value, $key) {
            return $value >= 150;
        });
        Arr::only($array, ['key']);//通过键名返回指定元素
        Arr::pluck($array, 'name', 'id');//从数组中检索给定键的所有值
        Arr::prepend($array, 'value', 'key'); //开头插入元素
        Arr::pull($array, 'name');//从数组中弹出指定键的值对
        Arr::query(['name' => 'Taylor', 'order' => ['column' => 'created_at', 'direction' => 'desc']]);//生成查询字符串
        Arr::random($array, 3, );//随机返回指定个数的元素
        Arr::shuffle([1, 2, 3, 4, 5]);//打乱数组元素

        //根据回调函数返回值排序
        Arr::sort($array, function ($value) {
            return $value['name'];
        });

        Arr::sortRecursive($array);
        //通过条件过滤
        Arr::where($array, function ($value, $key) {
            return is_string($value);
        });

        Arr::wrap('str');//转数组
        data_fill($array, 'key', 'default vlaue');// 函数使用「.」符号给多维数组或对象设置缺省值，如果键名已有值，则不变
        data_get();//支持*通配符
        data_set();//支持*通配符
        head($array);//返回第一个值
        last($array);//返回最后一个值
        app_path('Http/Controllers/Controller.php');//返回 app 目录的完整路径
        base_path('vendor/bin');//返回项目根目录的完整路径
        config_path('app.php');//返回配置文件的完整路径
        database_path('factories/UserFactory.php');//
        mix('css/app.css');//
        public_path('css/app.css');
        resource_path('sass/app.scss');
        storage_path('app/file.txt');
        echo __('messages.welcome'); //多语言
        class_basename('Foo\Bar\Baz');
        echo e('<html>foo</html>');//输出html

        $string = 'The event will take place between :start and :end';
        preg_replace_array('/:[a-z_]+/', ['8:30', '9:00'], $string);// The event will take place between 8:30 and 9:00

    }

    public function string()
    {
        Str::after('string', 'search'); //返回查找内容之后的字符串，没找到则返回全部字符串
        Str::afterLast('App\Http\Controllers\Controller', '\\');//查找最后一次出现
        Str::ascii('û');
        Str::before('This is my name', 'my name');
        Str::beforeLast('This is my name', 'is');
        Str::between('This is my name', 'This', 'name');

        Str::camel('foo_bar');//驼峰式
        Str::contains('This is my name', ['my']);
        Str::containsAll('This is my name', ['my', 'name']);//是否包含指定数组中的所有值
        Str::endsWith('This is my name', 'name');
        Str::finish('this/string/', '/');//将指定的字符串修改为以指定的值结尾的形式
        Str::is('baz*', 'foobar');//是否与指定模式匹配
        Str::isAscii('Taylor');//是否是字符
        Str::isUuid('laravel');
        Str::kebab('fooBar');
        Str::length('Laravel');
        Str::limit('The quick brown fox jumps over the lazy dog', 20, ' (...)');//截取字符串

        Str::lower('LARAVEL');
        Str::orderedUuid();
        Str::padBoth('James', 10, '_');
        Str::padLeft('James', 10, '-=');
        Str::padRight('James', 10);
        Str::plural('car');
        Str::plural('child', 2);
        Str::random();
        Str::replaceArray('?', ['8:00', '9:00'], 'time bewteen ? and ?');
        Str::replaceFirst('the', 'a', 'the quick brown fox jumps over the lazy dog'); //替换字符串中给定值的第一个匹配项
        Str::replaceLast('the', 'a', 'the quick brown fox jumps over the lazy dog');
        Str::singular('cars');//转换成单数形式
        Str::slug('Laravel 5 Framework', '-');
        Str::snake('fooBar');
        Str::start('this/string', '/');
        Str::startsWith('This is my name', 'This');//是否以指定字符开头
        Str::studly('foo_bar');//驼峰命名
        Str::substr('The Laravel Framework', 4, 7);
        Str::title('a nice title uses the correct case');//单词首字母大写
        Str::ucfirst('foo bar');
        Str::upper('laravel');
        Str::uuid();
        Str::words('Perfectly balanced, as all things should be.', 3, ' >>>');//限定单词个数
        trans('messages.welcome');
        trans_choice('messages.notifications', 12);//根据词形变化来翻译给定的翻译键
        Str::of('This is my name')->after('This is');//返回字符串中指定值后的所有内容
        Str::of('App\Http\Controllers\Controller')->afterLast('\\');//返回字符串中指定值最后一次出现后的所有内容
        Str::of('Taylor')->append(' Otwell');
        Str::of('ü')->ascii();//尝试将字符串转换为 ASCII 值
        Str::of('/foo/bar/baz')->basename();//返回文件名
        Str::of('This is my name')->before('my name');
        Str::of('This is my name')->beforeLast('is');
        Str::of('foo_bar')->camel();
        Str::of('This is my name')->contains('my');
        Str::of('This is my name')->containsAll(['my', 'name']);
        Str::of('/foo/bar/baz')->dirname(2);
        Str::of('This is my name')->endsWith('name');
        Str::of('Laravel')->exactly('Laravel');//完全相同
        Str::of('foo bar baz')->explode(' ');
        Str::of('this/string')->finish('/');
        Str::of('foobar')->is('foo*');
        Str::of('Taylor')->isAscii();
        Str::of('Laravel')->trim()->isEmpty();
        Str::of('Laravel')->trim()->isNotEmpty();
        Str::of('fooBar')->kebab();//烤串式
        Str::of('Laravel')->length();
        Str::of('The quick brown fox jumps over the lazy dog')->limit(20, ' (...)');
        Str::of('LARAVEL')->lower();
        Str::of('  Laravel  ')->ltrim();
        Str::of('foo bar')->match('/foo (.*)/');
        Str::of('bar foo bar')->matchAll('/bar/');
        Str::of('James')->padBoth(10, '_');
        Str::of('James')->padLeft(10, '-=');
        Str::of('James')->padRight(10, '-');
        Str::of('car')->plural();//复数形式
        Str::of('Framework')->prepend('Laravel ');
        Str::of('Laravel 6.x')->replace('6.x', '7.x');
        Str::of('The event will take place between ? and ?')->replaceArray('?', ['8:30', '9:00']);
        Str::of('the quick brown fox jumps over the lazy dog')->replaceFirst('the', 'a');
        Str::of('the quick brown fox jumps over the lazy dog')->replaceLast('the', 'a');
        Str::of('(+1) 501-555-1000')->replaceMatches('/[^A-Za-z0-9]++/', '');
        Str::of('123')->replaceMatches('/\d/', function ($match) {
            return '['.$match[0].']';
        });
        Str::of('  Laravel  ')->rtrim();
        Str::of('/Laravel/')->rtrim('/');
        Str::of('cars')->singular();//单数
        Str::of('Laravel Framework')->slug('-');
        Str::of('fooBar')->snake();
        Str::of('one, two, three')->split('/[\s,]+/');
        Str::of('/this/string')->start('/');
        Str::of('This is my name')->startsWith('This');
        Str::of('foo_bar')->studly();
        Str::of('Laravel Framework')->substr(8, 5);
        Str::of('a nice title uses the correct case')->title();
        Str::of('/Laravel/')->trim('/');
        Str::of('foo bar')->ucfirst();
        Str::of('laravel')->upper();
        Str::of('Taylor')->when(true, function ($string) {
            return $string->append(' Otwell');
        });
        Str::of('  ')->whenEmpty(function ($string) {
            return $string->trim()->prepend('Laravel');
        });
        Str::of('Perfectly balanced, as all things should be.')->words(3, ' >>>');
        action([UserController::class, 'profile'], ['id' => 1]);
        // ASSET_URL=http://example.com/assets
        $url = asset('img/photo.jpg'); // http://example.com/assets/img/photo.jpg
        route('routeName', ['id' => 1]);
        route('routeName', ['id' => 1], false);
        secure_asset('img/photo.jpg');
        secure_url('user/profile', [1]);
        url('user/profile', [1]);
        url()->current();
        url()->full();
        url()->previous();

    }

}
