<?php

namespace Tests\Unit\Http\Controllers\BackEnd;

use App\Models\Admins\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register_view()
    {
        $this->call('GET', route('backend.register'))
            ->assertStatus(200);
    }

    public function test_register_success()
    {
        $admin = new Admin ;
        $admin->username = 'NguyenVanA';
        $admin->email = '@gmail.com';
        $admin->password = '123456';
        $admin->active = 1;
        $this->assertTrue($admin->save());
    }

}
