<?php

namespace Tests\Unit\Middleware;

use Tests\SetupTestCase;
use App\Http\Middleware\VerifySubscriberMiddleware;

class VerifySubscriberTest extends SetupTestCase
{
    /**
     * 正常
     * @test
     */
    public function normalWithinLimits()
    {
        $this->seed('Tests\VerifySubscriberTests\VerifySubscriberTestNormalWithinLimitsSeeder');

        $request = app()->make('request');
        $request->merge(['auth0_sub' => config('const.test.sub')]);

        $middleware = new VerifySubscriberMiddleware();
        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        // Not return error response
        $this->assertNull($response);
    }

    /**
     * 准正常系
     * @test
     */
    public function nonNormalOutOfLimits()
    {
        $this->seed('Tests\VerifySubscriberTests\VerifySubscriberTestNonNormalOutOfLimitsSeeder');

        $request = app()->make('request');
        $request->merge(['auth0_sub' => config('const.test.sub')]);

        $middleware = new VerifySubscriberMiddleware();
        $originalResponse = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $response = $this->createTestResponse($originalResponse);

        // Not return error response
        $this->assertNotNull($response);

        $response
            ->assertStatus(402);
        // ->assertJson([
        //     'errors' => ['3 days 21 minutes 39 seconds'],
        // ]);
    }
}
