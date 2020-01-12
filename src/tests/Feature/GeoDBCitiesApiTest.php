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
    }

    /**
     * @test
     */
    public function should_正しくRESAS_APIが返ってくるか確認する()
    {
        $client = new Client();
        $sourceUrl = "https://opendata.resas-portal.go.jp/api/v1/prefectures";
        $responseData = $client->request("GET", $sourceUrl, array(
            'headers' => array(
                'X-API-KEY' => getenv('RESAS_API'),
                'Content-Type' => 'application/json;charset=UTF-8'
            ),
        ));
        $obj = json_decode($responseData->getBody());
        var_dump(getenv('RESAS_API'));
        $obj
            ->assertStatus(403);
    }
}
