<?php

namespace Tests\Feature\Api\User;

use App\User;
use Tests\SetupTestCase;

class UserCreateTest extends SetupTestCase
{
    private const ROUTE = 'user.create';
    private const METHOD = 'POST';

    /**
     * 正常
     * @test
     */
    public function normalToCreateUserApiWithoutUser()
    {
        $request = [];
        $response = $this->call(self::METHOD, route(self::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure of response data
        $this->assertEmpty($response->getContent());

        // Make sure users table has a row
        $this->assertDatabaseHas('users', [
            'unique_id' => config('const.test.sub'),
        ]);
    }

    /**
     * 正常
     * @test
     */
    public function normalToCreateUserApiWithUser()
    {
        // Create a user
        $this->setting = factory(User::class)->create();

        // Make sure users table has a row
        $this->assertDatabaseHas('users', [
            'unique_id' => config('const.test.sub'),
        ]);

        $request = [];
        $response = $this->call(self::METHOD, route(self::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure of response data
        $this->assertEmpty($response->getContent());

        // Make sure users table has a row
        $this->assertDatabaseHas('users', [
            'unique_id' => config('const.test.sub'),
        ]);
    }

    /**
     * 准正常系
     * @test
     */
    public function nonNormalToCreateUserApi()
    {
        $request = [];
        $response = $this->withoutMiddleware()->call(self::METHOD, route(self::ROUTE), $request, [], [], []);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'auth0_sub' => ['The auth0 sub field is required.'],
                ]
            ]);

        // Make sure users table has no row
        $this->assertDatabaseMissing('users', [
            'unique_id' => config('const.test.sub'),
        ]);
    }
}
