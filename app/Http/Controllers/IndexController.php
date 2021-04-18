<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class IndexController extends Controller {

    public function index(){

        $route = Route::current();

        $name = Route::currentRouteName();

        $action = Route::currentRouteAction();
        p($route, $name, $action);
        return URL::signedRoute('test', ['user' => 1]);
    }

}
