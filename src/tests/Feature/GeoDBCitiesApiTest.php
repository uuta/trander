<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;

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
    public function should_GeoDBCities_APIへのリクエストに成功するか確認する()
    {
        // 仮の指定地点をリクエストパラメーターに設定
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995
        ];
        $response = $this->post(route('geo-db-cities'), $request);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK'
            ]);
    }
}
