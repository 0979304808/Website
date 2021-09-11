<?php

namespace Tests\Unit\Models\Admins;

use App\Models\Admins\Admin;
use App\Models\Posts\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_hashes_password_when_set()
    {
        Hash::shouldReceive('make')->once()->andReturn('hashed');
        $author = new Admin;
        $author->password = 'foo';
        $this->assertEquals('hashed', $author->password);
    }


}
