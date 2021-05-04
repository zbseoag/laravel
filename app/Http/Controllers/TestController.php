<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {

    public function index(){

        //uopz_add_function('foo', function () {echo 'bar';});
        User::query()->first();
    }

}
