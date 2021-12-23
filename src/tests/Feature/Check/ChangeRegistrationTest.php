<?php

namespace Tests\Feature\Check;

use App\User;
use Tests\SetUpTestCase;

class ChangeRegistrationTest extends SetUpTestCase
{
    private const ROUTE = 'change-registration';

    /**
     * 正常
     * @test
     */
    public function should_Change_Registration_APIへのリクエストに成功する()
    {
        $response = $this->call('POSt', route($this::ROUTE), [], [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure imported record
        $user = User::where('email', config('const.test.email'))->first();
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'check_registration' => User::REGISTERED,
        ]);
    }
}
