<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {

    public function index(){
        $record = DB::select('select * from users where active = ?', [1]);

        return 1;
    }

}
