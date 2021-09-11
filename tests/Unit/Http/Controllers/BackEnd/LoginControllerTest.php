<?php

namespace Tests\Unit\Http\Controllers\BackEnd;

use App\Models\Admins\Admin;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_login_view()
    {
        $this->call('GET',route('backend.index'))
            ->assertStatus(200);

    }
    // Login thành công
    public function test_login_success()
    {
        $this->post('/login', ['email' => 'hung@gmail.com', 'password' => '123456', 'active' => 1])
            ->assertRedirect('/dashboard')
            ->assertStatus(302);

    }
    // login thất bại
    public function test_login_error()
    {
        $this->post('/login', ['email' => 'hung@gmail.com', 'password' => '1234566', 'active' => 1])
            ->assertRedirect('/')
            ->assertStatus(302);
    }
}
