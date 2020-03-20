<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class GeoDBCitiesApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function should_GeoDBCities_APIへのリクエストに成功する()
    {
        // 仮の指定地点をリクエストパラメーターに設定
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
            'min' => 0,
            'max' => 25,
        ];
        $response = $this->post(route('geo-db-cities'), $request);
        $response
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function should_GeoDBCities_APIへのリクエストで204が返ってくる()
    {
        // 100km圏内に都市がない緯度経度をリクエストパラメーターに設定
        $request = [
            'lat' => 35.188444,
            'lng' => 152.442722,
            'min' => 0,
            'max' => 25,
        ];
        $code = 'データなし';
        $message = '該当するデータが存在しませんでした。距離を変更のうえ再度お試しください。';
        $response = $this->post(route('geo-db-cities'), $request);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 204,
                'errors' => [
                    'code' => $code,
                    'message' => $message
                ]
            ]);
    }
}
