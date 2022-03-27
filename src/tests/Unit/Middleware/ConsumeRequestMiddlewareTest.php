<?php

namespace Tests\Unit\Middleware;

use Tests\SetupTestCase;
use App\Http\Middleware\ConsumeRequestMiddleware;
use Tests\VerifySubscriberTests\VerifySubscriberTestNormalFullLimitsSeeder;

class ConsumeRequestMiddlewareTest extends SetupTestCase
{
    /**
     * 正常
     * @test
     */
    public function normalWithinLimits()
    {
        $this->seed('Tests\VerifySubscriberTests\VerifySubscriberTestNormalFullLimitsSeeder');

        $request = app()->make('request');
        $request->merge(['auth0_sub' => config('const.test.sub')]);

        $middleware = new ConsumeRequestMiddleware();
        $response = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        // Not return error response
        $this->assertNull($response);

        // Request count histories
        $this->assertDatabaseHas('request_limits', [
            'request_limit' => VerifySubscriberTestNormalFullLimitsSeeder::LIMIT - 1,
        ]);
    }

    /**
     * 正常系
     * @test
     */
    public function nonNormalOutOfLimits()
    {
        $this->seed('Tests\VerifySubscriberTests\VerifySubscriberTestNonNormalOutOfLimitsSeeder');

        $request = app()->make('request');
        $request->merge(['auth0_sub' => config('const.test.sub')]);

        $middleware = new ConsumeRequestMiddleware();
        $originalResponse = $middleware->handle($request, function () {
            $this->assertTrue(true);
        });

        $response = $this->createTestResponse($originalResponse);

        // Not return error response
        $this->assertNotNull($response);

        // Request count histories
        $this->assertDatabaseHas('request_limits', [
            'request_limit' => 0,
        ]);
    }
}
