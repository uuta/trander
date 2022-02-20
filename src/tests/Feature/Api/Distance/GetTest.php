<?php

namespace Tests\Feature\Api\Distance;

use Tests\SetUpTestCase;

class GetTest extends SetUpTestCase
{
    private const ROUTE = 'distance.get';

    /**
     * 正常
     * @test
     */
    public function should_get_distance_APIへのリクエストに成功する()
    {
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
            'targetLat' => 43.068933,
            'targetLng' => 141.332181,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
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
        $request = [];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['The lat field is required.'],
                    'lng' => ['The lng field is required.'],
                    'targetLat' => ['The target lat field is required.'],
                    'targetLng' => ['The target lng field is required.'],
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
            'targetLat' => 200,
            'targetLng' => 500,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['The lat must be between -90 and 90.'],
                    'lng' => ['The lng must be between -180 and 180.'],
                    'targetLat' => ['The target lat must be between -90 and 90.'],
                    'targetLng' => ['The target lng must be between -180 and 180.'],
                ]
            ]);
    }
}
