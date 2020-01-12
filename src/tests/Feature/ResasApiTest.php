<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResasApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function should_RESAS_APIへのリクエストに成功するか確認する()
    {
        $response = $this->get(route('resas'));
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK'
            ]);
    }
}
