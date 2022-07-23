<?php

namespace Tests\Feature\Api\Backpacker\Cities;

use Tests\SetUpTestCase;
use App\Http\Models\RequestCountHistory;

class BackpackerCitiesIndexTest extends SetUpTestCase
{
    private const ROUTE = 'backpacker.cities.get';

    /**
     * 正常
     * @test
     */
    public function should_BackpackerCities_APIへのリクエストに成功する()
    {
        $request = [];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // レスポンスの中身の確認
        $data = $response->json();
        $this->assertCount(13, $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('wikiDataId', $data);
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

        // Make sure imported record in google place ids
        $this->assertDatabaseHas('google_place_ids', [
            'place_id' => $data['placeId'],
            'name' => $data['name'],
            'icon' => $data['icon'],
            'rating' => (float)$data['rating'],
            'photo' => $data['photo'],
            'vicinity' => $data['vicinity'],
            'user_ratings_total' => (int)$data['userRatingsTotal'],
            'price_level' => $data['priceLevel'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'rating_star' => $data['ratingStar'],
        ]);

        // Request count histories
        $this->assertDatabaseHas('request_count_historys', [
            'type_id' => RequestCountHistory::TYPE_ID['backpackerCities'],
        ]);
    }
}
