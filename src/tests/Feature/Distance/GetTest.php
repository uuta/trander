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
                    'lat' => ['「lat」フィールドの入力は必須です。'],
                    'lng' => ['「lng」フィールドの入力は必須です。'],
                    'cityLat' => ['「city lat」フィールドの入力は必須です。'],
                    'cityLng' => ['「city lng」フィールドの入力は必須です。'],
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
                    'lat' => ['「lat」は、-90と90の間の値である必要があります。'],
                    'lng' => ['「lng」は、-180と180の間の値である必要があります。'],
                    'cityLat' => ['「city lat」は、-90と90の間の値である必要があります。'],
                    'cityLng' => ['「city lng」は、-180と180の間の値である必要があります。'],
                ]
            ]);
    }
}
