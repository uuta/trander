<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\MWay;

class GeoDBCitiesApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->seed('MWaysSeeder');
    }

    /**
     * 正常
     * @test
     */
    public function should_GeoDBCities_APIへのリクエストに成功する()
    {
        // 仮の指定地点をリクエストパラメーターに設定
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
            'min' => 0,
            'max' => 50000,
        ];
        $response = $this->post(route('geo-db-cities'), $request);
        $response->assertStatus(200);

        // レスポンスの中身の確認
        $data = $response->json(['data']);
        $data = array_shift($data);
        $this->assertCount(1, $response->json(['data']));
        $this->assertInternalType('string', $data['countryCode']);
        $this->assertInternalType('string', $data['city']);
        $this->assertInternalType('string', $data['region']);
        $this->assertInternalType('float', $data['distance']);
        $this->assertInternalType('array', $data['ways']);
        ;
        $this->assertTrue(in_array($data['ways']['walking'], MWay::RECOMMEND_FREQUENCY));
        $this->assertTrue(in_array($data['ways']['bycicle'], MWay::RECOMMEND_FREQUENCY));
        $this->assertTrue(in_array($data['ways']['car'], MWay::RECOMMEND_FREQUENCY));
    }

    /**
     * 正常
     * @test
     */
    public function should_GeoDBCities_APIへのリクエストで204が返ってくる()
    {
        // 100km圏内に都市がない緯度経度をリクエストパラメーターに設定
        $request = [
            'lat' => 35.188444,
            'lng' => 152.442722,
            'min' => 0,
            'max' => 50000,
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
