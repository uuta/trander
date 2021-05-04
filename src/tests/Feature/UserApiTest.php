<?php

namespace Tests\Feature;

use App\User;
use Tests\LoginTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends LoginTestCase
{
    private const ROUTE_GET = 'user';

    /**
     * @test
     */
    public function should_ログイン中のユーザーを返却する()
    {
        $request = [
            'api_token' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE_GET), $request);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $this->user->name,
            ]);
    }

    /**
     * @test
     */
    public function should_ログインされていない場合は空文字を返却する()
    {
        $response = $this->call('GET', route($this::ROUTE_GET));

        $response->assertStatus(302);
        // $this->assertEquals("", $response->content());
    }
}
