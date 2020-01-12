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
        $response = $this->get(route('geo-db-cities'));
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK'
            ]);
    }
}
