<?php

namespace Tests\Feature\Check;

use Tests\LoginTestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangeRegistrationTest extends LoginTestCase
{
    private const ROUTE = 'change-registration';

    /**
     * 正常
     * @test
     */
    public function should_Change_Registration_APIへのリクエストに成功する()
    {
        $request = [
            'apiToken' => $this->user->api_token,
        ];
        $response = $this->call('POST', route($this::ROUTE, $request));
        $response->assertStatus(200);

        // Make sure imported record
        $this->assertDatabaseHas('users', [
            'api_token' => $this->user->api_token,
            'check_registration' => User::REGISTERED,
        ]);
    }
}
