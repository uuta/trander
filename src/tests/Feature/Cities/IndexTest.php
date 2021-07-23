<?php

namespace Tests\Feature\Cities;

use Tests\LoginTestCase;
use App\Setting;
use GuzzleHttp\Client;

class IndexTest extends LoginTestCase
{
    private const ROUTE = 'cities.get';

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
    public function succeed_request_to_cities_API()
    {
        // Request with a temporary location
        $request = [
            'lat' => 34.673521,
            'lng' => 135.507772,
            'max' => 3,
            'min' => 0,
            'directionType' => Setting::DIRECTION_TYPE['none'],
            'apiToken' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json()['data'];
        $this->assertCount(14, $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('distance', $data);
        $this->assertArrayHasKey('direction', $data);
        $this->assertArrayHasKey('countryCode', $data);
        $this->assertArrayHasKey('icon', $data);
        $this->assertArrayHasKey('rating', $data);
        $this->assertArrayHasKey('photo', $data);
        $this->assertArrayHasKey('vicinity', $data);
        $this->assertArrayHasKey('userRatingsTotal', $data);
        $this->assertArrayHasKey('priceLevel', $data);
        $this->assertArrayHasKey('lat', $data);
        $this->assertArrayHasKey('lng', $data);
        $this->assertArrayHasKey('placeId', $data);
        $this->assertArrayHasKey('ratingStar', $data);
    }

    /**
     * 正常
     * @test
     */
    public function succeed_request_to_cities_API_204()
    {
        // 100km圏内に都市がない緯度経度をリクエストパラメーターに設定
        $request = [
            'lat' => 35.188444,
            'lng' => 152.442722,
            'min' => 0,
            'max' => 50,
            'directionType' => Setting::DIRECTION_TYPE['none'],
            'apiToken' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(204);
    }

    /**
     * 準正常
     * @test
     */
    public function failed_request_to_cities_API_422()
    {
        $request = [
            'lat' => 34.673521,
            'lng' => 135.507772,
            'max' => 3,
            'directionType' => Setting::DIRECTION_TYPE['none'],
            'apiToken' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'min' => ['The min field is required.']
                ]
            ]);
    }
}
