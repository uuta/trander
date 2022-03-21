<?php

namespace Tests\Feature\Api\Cities;

use Tests\SetUpTestCase;
use App\Http\Models\Setting;
use App\Http\Models\RequestCountHistory;

class CitiesIndexTest extends SetUpTestCase
{
    private const ROUTE = 'cities.get';

    /**
     * 正常
     * @test
     */
    public function succeed_request_to_cities_API()
    {
        // Request with a temporary location
        $request = [
            'lat' => 34.673521,
            'lng' => 135.507772,
            'max' => 100,
            'min' => 0,
            'directionType' => Setting::DIRECTION_TYPE['none'],
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(15, $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('wikiDataId', $data);
        $this->assertArrayHasKey('distance', $data);
        $this->assertArrayHasKey('direction', $data);
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

        if ($data['countryCode']) $this->assertTrue(ctype_lower($data['countryCode']));

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
            'type_id' => RequestCountHistory::TYPE_ID['indexCities'],
        ]);
    }

    /**
     * 正常
     * @test
     */
    public function succeed_request_with_north_to_cities_API()
    {
        // Request with a temporary location
        $request = [
            'lat' => 34.673521,
            'lng' => 135.507772,
            'max' => 100,
            'min' => 0,
            'directionType' => Setting::DIRECTION_TYPE['north'],
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(15, $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('wikiDataId', $data);
        $this->assertArrayHasKey('distance', $data);
        $this->assertArrayHasKey('direction', $data);
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
            'type_id' => RequestCountHistory::TYPE_ID['indexCities'],
        ]);
    }

    /**
     * 正常
     * @test
     */
    public function succeed_request_with_west_to_cities_API()
    {
        // Request with a temporary location
        $request = [
            'lat' => 34.673521,
            'lng' => 135.507772,
            'max' => 100,
            'min' => 0,
            'directionType' => Setting::DIRECTION_TYPE['west'],
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(15, $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('wikiDataId', $data);
        $this->assertArrayHasKey('distance', $data);
        $this->assertArrayHasKey('direction', $data);
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
            'type_id' => RequestCountHistory::TYPE_ID['indexCities'],
        ]);
    }

    /**
     * 正常
     * @test
     */
    public function succeed_request_to_cities_API_204()
    {
        // 100km圏内に都市がない緯度経度をリクエストパラメーターに設定
        $request = [
            'lat' => 35.188444,
            'lng' => 152.442722,
            'min' => 0,
            'max' => 50,
            'directionType' => Setting::DIRECTION_TYPE['none'],
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(204);
    }

    /**
     * 準正常
     * @test
     */
    public function failed_request_to_cities_API_422()
    {
        $request = [
            'lat' => 34.673521,
            'lng' => 135.507772,
            'max' => 3,
            'directionType' => Setting::DIRECTION_TYPE['none'],
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'min' => ['The min field is required.']
                ]
            ]);
    }
}
