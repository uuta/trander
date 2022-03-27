<?php

namespace Tests\Feature\Api\GeoDBCities;

use App\Http\Models\User;
use Tests\SetUpTestCase;
use App\Http\Models\RequestCountHistory;

class GetIdTest extends SetUpTestCase
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
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // レスポンスの中身の確認
        $data = $response->json();
        $this->assertCount(8, $data);
        $this->assertArrayHasKey('city', $data);
        $this->assertArrayHasKey('country', $data);
        $this->assertArrayHasKey('countryCode', $data);
        $this->assertArrayHasKey('latitude', $data);
        $this->assertArrayHasKey('longitude', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('region', $data);
        $this->assertArrayHasKey('wikiDataId', $data);

        // Make sure imported record
        $user = User::where('email', config('const.test.email'))->first();
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $user->id,
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
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'id' => ['The id must be an integer.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_GetId_GeoDBCities_APIへのリクエストが失敗する（404）()
    {
        $request = [
            'id' => 1232147491279,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(404);
    }
}
