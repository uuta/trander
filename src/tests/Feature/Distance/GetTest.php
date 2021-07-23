<?php

namespace Tests\Feature\Distance;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\LoginTestCase;

class GetTest extends LoginTestCase
{
    private const ROUTE = 'distance.get';

    public function setUp()
    {
        parent::setUp();
        $this->seed('MWaysSeeder');
        $this->seed('MDirectionSeeder');
    }

    /**
     * 正常
     * @test
     */
    public function should_get_distance_APIへのリクエストに成功する()
    {
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
            'cityLat' => 43.068933,
            'cityLng' => 141.332181,
            'apiToken' => $this->user->api_token
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(3, $data);
        $this->assertArrayHasKey('distance', $data);
        $this->assertArrayHasKey('ways', $data);
        $this->assertArrayHasKey('direction', $data);
    }

    /**
     * 準正常
     * @test
     */
    public function should_get_distance_APIへのリクエストが失敗する（バリデーション）（空）()
    {
        // Empty parameter
        $request = [
            'apiToken' => $this->user->api_token
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['The lat field is required.'],
                    'lng' => ['The lng field is required.'],
                    'cityLat' => ['The city lat field is required.'],
                    'cityLng' => ['The city lng field is required.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_get_distance_APIへのリクエストが失敗する（バリデーション）（最大・最小値）()
    {
        // Uncorrected parameter
        $request = [
            'lat' => 200,
            'lng' => 500,
            'cityLat' => 200,
            'cityLng' => 500,
            'apiToken' => $this->user->api_token
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['The lat must be between -90 and 90.'],
                    'lng' => ['The lng must be between -180 and 180.'],
                    'cityLat' => ['The city lat must be between -90 and 90.'],
                    'cityLng' => ['The city lng must be between -180 and 180.'],
                ]
            ]);
    }
}
