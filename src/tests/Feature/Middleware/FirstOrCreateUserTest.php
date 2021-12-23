<?php

namespace Tests\Feature\Middleware;

use App\User;
use Tests\SetupTestCase;
use App\Http\Middleware\FirstOrCreateUserMiddleware;

class FirstOrCreateUserTest extends SetupTestCase
{
    /**
     * 正常
     * @test
     */
    public function normalScenarioUserNil()
    {
        $request = app()->make('request');
        $request->merge(['auth0_email' => config('const.test.email')]);

        $middleware = new FirstOrCreateUserMiddleware();
        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        // Not return error response
        $this->assertNull($response);

        $this->assertDatabaseHas('users', [
            'email' => config('const.test.email'),
        ]);
    }

    /**
     * 正常
     * @test
     */
    public function normalScenarioUserExists()
    {
        // Pre insert user
        User::create(['email' => config('const.test.email')]);

        $request = app()->make('request');
        $request->merge(['auth0_email' => config('const.test.email')]);

        $middleware = new FirstOrCreateUserMiddleware();
        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        // Not return error response
        $this->assertNull($response);

        $user = User::where('email', config('const.test.email'))->get();
        $this->assertTrue($user->count() === 1);
        $this->assertDatabaseHas('users', [
            'email' => config('const.test.email'),
        ]);
    }

    /**
     * 准正常系
     * @test
     */
    public function nonNormalScenarioWithWrongEmail()
    {
        $request = app()->make('request');
        $request->merge(['auth0_email' => 'aaaaaaaaaa']);

        $middleware = new FirstOrCreateUserMiddleware();
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
                    'auth0_email' => ['The auth0 email must be a valid email address.'],
                ]
            ]);
    }

    /**
     * 准正常系
     * @test
     */
    public function nonNormalScenarioWithNoEmail()
    {
        $request = app()->make('request');

        $middleware = new FirstOrCreateUserMiddleware();
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
                    'auth0_email' => ['The auth0 email field is required.'],
                ]
            ]);
    }
}
