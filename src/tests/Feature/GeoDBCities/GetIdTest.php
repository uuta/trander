<?php

namespace Tests\Feature\GeoDBCities;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\LoginTestCase;
use App\RequestCountHistory;

class GetIdTest extends LoginTestCase
{
    private const ROUTE = 'geo-db-cities.get';

    /**
     * 正常
     * @test
     */
    public function should_GetId_GeoDBCities_APIへのリクエストに成功する()
    {
        $request = [
            'id' => 123214,
        ];
        $response = $this->call('GET', route($this::ROUTE, $request));
        $response->assertStatus(200);

        // レスポンスの中身の確認
        $data = $response->json(['data']);
        $this->assertCount(8, $response->json(['data']));
        $this->assertArrayHasKey('city', $data);
        $this->assertArrayHasKey('country', $data);
        $this->assertArrayHasKey('countryCode', $data);
        $this->assertArrayHasKey('latitude', $data);
        $this->assertArrayHasKey('longitude', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('region', $data);
        $this->assertArrayHasKey('wikiDataId', $data);

        // Make sure imported record
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $this->user->id,
            'type_id' => RequestCountHistory::TYPE_ID['getGeoDbCitiesId'],
        ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_GetId_GeoDBCities_APIへのリクエストが失敗する（バリデーション）（型）()
    {
        // Uncorrected parameter
        $request = [
            'id' => 'string',
        ];
        $response = $this->call('GET', route($this::ROUTE, $request));
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'id' => ['「id」は、数値形式で入力してください。'],
                ]
            ]);
    }
}
