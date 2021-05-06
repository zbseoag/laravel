<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class IndexController extends Controller {

    public function index(){

        $route = Route::current();
        $name = Route::currentRouteName();
        $action = Route::currentRouteAction();
        return URL::signedRoute('test', ['user' => 1]);
    }

    public function modelFactory(){

        User::factory()->count(2)->deleted()->create();

    }

}
