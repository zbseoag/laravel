<?php

namespace Tests\Feature;

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

        echo User::query()->where('id', 1)->dump();
        echo 'end';
    }
}
