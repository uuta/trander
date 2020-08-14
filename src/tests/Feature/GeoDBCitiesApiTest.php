<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\MWay;
use Illuminate\Support\Facades\DB;
use App\Setting;

class GeoDBCitiesApiTest extends TestCase
{
    use RefreshDatabase;

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
    public function should_GeoDBCities_APIへのリクエストに成功する()
    {
        // 仮の指定地点をリクエストパラメーターに設定
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
            'min' => 0,
            'max' => 50000,
            'direction_type' => Setting::DIRECTION_TYPE['none']
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
        // 方角の確認
        $directions = DB::table('m_directions')->select('direction_name')->get()->toArray();
        $this->assertTrue(in_array($data['direction'], array_column($directions, 'direction_name')));
    }

    /**
     * 正常
     * @test
     */
    public function should_方角を指定してGeoDBCities_APIへのリクエストに成功する()
    {
        // 北の指定地点をリクエストパラメーターに設定
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
            'min' => 10000,
            'max' => 50000,
            'direction_type' => Setting::DIRECTION_TYPE['south']
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
        // 方角の確認（北は方角として来る）
        $directions = DB::table('m_directions')->whereBetween('direction_id', [4, 8])->get()->toArray();
        $this->assertTrue(in_array($data['direction'], array_column($directions, 'direction_name')));
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
            'direction_type' => Setting::DIRECTION_TYPE['none']
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

    /**
     * 準正常
     * @test
     */
    public function should_GeoDBCities_APIへのリクエストが失敗する（バリデーション）()
    {
        // 仮の指定地点をリクエストパラメーターに設定
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
            'min' => 0,
            'max' => 50000,
        ];
        $response = $this->post(route('geo-db-cities'), $request);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'direction_type' => ['「direction type」フィールドの入力は必須です。']
                ]
            ]);
    }
}
