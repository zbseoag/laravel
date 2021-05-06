<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {

    public function index(){
        stop(debug_backtrace());
        //debug_print_backtrace();
        //uopz_add_function('foo', function () {echo 'bar';});
        //User::query()->first();
    }

}
