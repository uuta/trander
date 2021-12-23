<?php

namespace Tests\Feature\Api\NearBySearch;

use App\User;
use App\Setting;
use Tests\SetUpTestCase;
use App\RequestCountHistory;

class GetTest extends SetUpTestCase
{
    private const ROUTE = 'near-by-search.get';

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('MRatingsSeeder');
    }

    /**
     * 正常
     * @test
     */
    public function should_near_by_search_APIへのリクエストに成功する()
    {
        $request = [
            'lat' => 35.691510,
            'lng' => 139.878927,
            'keyword' => '温泉',
            'max' => 3,
            'min' => 0,
            'directionType' => Setting::DIRECTION_TYPE['none'],
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(11, $data);
        $this->assertArrayHasKey('name', $data);
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

        // Make sure imported record in history table
        $user = User::where('email', config('const.test.email'))->first();
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $user->id,
            'type_id' => RequestCountHistory::TYPE_ID['getNearBySearch'],
        ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_near_by_search_APIへのリクエストが失敗する（バリデーション）（空）()
    {
        // Empty parameter
        $request = [];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['The lat field is required.'],
                    'lng' => ['The lng field is required.'],
                    'keyword' => ['The keyword field is required.'],
                    'max' => ['The max field is required.'],
                    'min' => ['The min field is required.'],
                    'directionType' => ['The direction type field is required.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_near_by_search_APIへのリクエストが失敗する（バリデーション）（値）()
    {
        // Uncorrected parameter
        $request = [
            'lat' => 200,
            'lng' => 500,
            'keyword' => 22,
            'max' => -10,
            'min' => -10,
            'directionType' => 'aaaaaa',
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['The lat must be between -90 and 90.'],
                    'lng' => ['The lng must be between -180 and 180.'],
                    'keyword' => ['The keyword must be a string.'],
                    'max' => ['The max must be between 0 and  100.'],
                    'min' => ['The min must be between 0 and  100.'],
                    'directionType' => ['The direction type must be an integer.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_near_by_search_APIへのリクエストが失敗する（404）()
    {
        $request = [
            'lat' => 68.752491,
            'lng' => 175.827562,
            'keyword' => '温泉',
            'max' => 3,
            'min' => 0,
            'directionType' => Setting::DIRECTION_TYPE['none'],
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(404);
    }
}
