<?php

namespace Tests\Feature\Api\User;

use App\Http\Models\User;
use Tests\SetUpTestCase;

class UserShowTest extends SetUpTestCase
{
    private const ROUTE_GET = 'user.show';

    /**
     * @test
     */
    public function should_ログイン中のユーザーを返却する()
    {
        $response = $this->call('GET', route($this::ROUTE_GET), [], [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);

        $user = User::where('email', config('const.test.email'))->first();
        $response
            ->assertStatus(200)
            ->assertJson([
                'email' => $user->email,
            ]);
    }
}
