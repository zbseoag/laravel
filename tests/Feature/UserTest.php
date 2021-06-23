<?php

namespace Tests\Feature;

use App\Tools\Calc;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_bb()
    {

        echo User::query()->where('id', 1)->dd();
        echo 'end';
    }

    public function test_demo()
    {
        echo Calc::add(10, 9,8,4)->sub(4)->mul(10, 2, 3)->value();
    }

}
