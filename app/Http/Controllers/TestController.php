<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class TestController extends Controller {

    public function index(){

        var_dump(Arr::only(['a'=>1, 'b'=>'2', 'c'=>33], ['a', 'b']));
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
