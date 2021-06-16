<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class TestController extends Controller {

    public function index(){

        $array = [1,2,3,4];
        $array = Arr::add($array, 2, 'value');//添加元素当元素或不存在时
        pp($array);

        //$users = User::cursor()->where('id', '>', 3)->take(30)->get();

    }

    public function test222(){
        $route = Route::current();
        $name = Route::currentRouteName();
        $action = Route::currentRouteAction();
        return URL::signedRoute('test', ['user' => 1]);
        //debug_print_backtrace();
        //uopz_add_function('foo', function () {echo 'bar';});
        //User::query()->first();
        User::factory()->count(2)->deleted()->create();
    }

}
