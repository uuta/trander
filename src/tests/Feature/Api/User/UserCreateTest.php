<?php

namespace Tests\Feature\Api\User;

use Tests\SetupTestCase;
use App\Http\Controllers\UserController;

// TODO: Make sure to work collectly
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

        // Make sure response data
        $data = $response->json()['data'];
        $this->assertCount(0, $data);

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
        $request = [];
        $response = $this->call(self::METHOD, route(self::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json()['data'];
        $this->assertCount(0, $data);

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
        // TODO: test
        $request = app()->make('request');

        $middleware = new UserController();
        $originalResponse = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $response = $this->createTestResponse($originalResponse);

        // Not return error response
        $this->assertNotNull($response);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'auth0_sub' => ['The auth0 sub field is required.'],
                ]
            ]);
    }
}
