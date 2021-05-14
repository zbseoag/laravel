<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {

    public function index(){

        echo 222;
        exit;
        $users = User::cursor()->where('id', '>', 3)->take(30)->get();

        foreach ($users as $user) {
            echo $user->id;
        }

    }

}
