<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testing by a login user
 *
 * @author Yuta Aoki
 */
class LoginTestCase extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        // Make a test user
        $this->user = factory(User::class)->create();
        $login = $this->json('POST', route('login'), [
            'email' => $this->user->email,
            'password' => 'secret',
        ]);
        $login->assertStatus(200);
    }
}