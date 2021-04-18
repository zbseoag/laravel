<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

Route::get('/', function () {return view('welcome'); });

Route::get('/index', [IndexController::class, 'index'])->name('test');


//设置语言
Route::get('welcome/{locale}', function ($locale){
    if (!in_array($locale, ['en', 'es', 'fr'])) {
        abort(400);
    }
    App::setLocale($locale);

});

