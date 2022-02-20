<?php

namespace Tests\Feature\Api\GeoDBCities;

use Tests\SetUpTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\MWay;
use Illuminate\Support\Facades\DB;
use App\Setting;

class PostTest extends SetUpTestCase
{

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
            'max' => 50,
            'directionType' => Setting::DIRECTION_TYPE['none'],
        ];
        $response = $this->post(route('geo-db-cities'), $request, [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // レスポンスの中身の確認
        $data = $response->json(['data']);
        $data = array_shift($data);
        $this->assertCount(1, $response->json(['data']));
        $this->assertInternalType('string', $data['countryCode']);
        $this->assertInternalType('string', $data['city']);
        $this->assertInternalType('string', $data['region']);
        $this->assertInternalType('float', round($data['distance']));
        $this->assertInternalType('array', $data['ways']);;
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
            'min' => 10,
            'max' => 50,
            'directionType' => Setting::DIRECTION_TYPE['south'],
        ];
        $response = $this->post(route('geo-db-cities'), $request, [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // レスポンスの中身の確認
        $data = $response->json(['data']);
        $data = array_shift($data);
        $this->assertCount(1, $response->json(['data']));
        $this->assertInternalType('string', $data['countryCode']);
        $this->assertInternalType('string', $data['city']);
        $this->assertInternalType('string', $data['region']);
        $this->assertInternalType('float', round($data['distance']));
        $this->assertInternalType('array', $data['ways']);;
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
            'max' => 50,
            'directionType' => Setting::DIRECTION_TYPE['none'],
        ];
        $response = $this->post(route('geo-db-cities'), $request, [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(204);
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
            'max' => 50,
        ];
        $response = $this->post(route('geo-db-cities'), $request, [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'directionType' => ['The direction type field is required.']
                ]
            ]);
    }
}
