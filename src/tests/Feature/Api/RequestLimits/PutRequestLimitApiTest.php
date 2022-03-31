<?php

namespace Tests\Feature\Api\RequestLimits;

use Tests\SetUpTestCase;
use App\Http\Models\RequestLimit;

class PutRequestLimitApiTest extends SetUpTestCase
{
    private const ROUTE = 'request-limit.put';
    private const METHOD = 'PUT';

    /**
     * 正常系
     * @test
     */
    public function succeedRequestToPutRequestLimitApi()
    {
        $this->seed('Tests\RequestLimits\RequestLimitSeeder');
        $this->artisan('command:restore-request-limit');

        $request = [];
        $response = $this->call(self::METHOD, route(self::ROUTE), $request);
        $response->assertStatus(200);

        $res = RequestLimit::all();
        $this->assertEquals(4, count($res));
        $this->assertEquals(10, $res[0]->request_limit);
        $this->assertEquals(10, $res[1]->request_limit);
        $this->assertEquals(2, $res[2]->request_limit);
        $this->assertEquals(10, $res[3]->request_limit);
    }
}
