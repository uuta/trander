<?php

namespace Tests\Feature\Commands;

use Tests\SetupTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Models\RequestLimit;

class RestoreRequestLimitCommandTest extends SetupTestCase
{
    /**
     * Normal test
     * @test
     */
    public function normal()
    {
        $this->seed('Tests\RequestLimits\RequestLimitSeeder');
        $this->artisan('command:restore-request-limit');

        $res = RequestLimit::all();
        $this->assertEquals(4, count($res));
        $this->assertEquals(10, $res[0]->request_limit);
        $this->assertEquals(10, $res[1]->request_limit);
        $this->assertEquals(2, $res[2]->request_limit);
        $this->assertEquals(10, $res[3]->request_limit);
    }
}
