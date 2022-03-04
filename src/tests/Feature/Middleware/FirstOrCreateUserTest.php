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
        $request->merge(['auth0_sub' => config('const.test.sub')]);

        $middleware = new FirstOrCreateUserMiddleware();
        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        // Not return error response
        $this->assertNull($response);

        $this->assertDatabaseHas('users', [
            'unique_id' => config('const.test.sub'),
        ]);
    }

    /**
     * 正常
     * @test
     */
    public function normalScenarioUserExists()
    {
        // Pre insert user
        User::create(['unique_id' => config('const.test.sub')]);

        $request = app()->make('request');
        $request->merge(['auth0_sub' => config('const.test.sub')]);

        $middleware = new FirstOrCreateUserMiddleware();
        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        // Not return error response
        $this->assertNull($response);

        $user = User::where('unique_id', config('const.test.sub'))->get();
        $this->assertTrue($user->count() === 1);
        $this->assertDatabaseHas('users', [
            'unique_id' => config('const.test.sub'),
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
                    'auth0_sub' => ['The auth0 sub field is required.'],
                ]
            ]);
    }
}
