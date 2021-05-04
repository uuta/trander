<?php

namespace Tests\Feature\NearBySearch;

use Tests\LoginTestCase;
use App\RequestCountHistory;
use App\Setting;

class GetTest extends LoginTestCase
{
    private const ROUTE = 'near-by-search.get';

    public function setUp()
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
            'api_token' => $this->user->api_token
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
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
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $this->user->id,
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
        $request = [
            'api_token' => $this->user->api_token
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['「lat」フィールドの入力は必須です。'],
                    'lng' => ['「lng」フィールドの入力は必須です。'],
                    'keyword' => ['「keyword」フィールドの入力は必須です。'],
                    'max' => ['「max」フィールドの入力は必須です。'],
                    'min' => ['「min」フィールドの入力は必須です。'],
                    'directionType' => ['「direction type」フィールドの入力は必須です。'],
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
            'api_token' => $this->user->api_token
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['「lat」は、-90と90の間の値である必要があります。'],
                    'lng' => ['「lng」は、-180と180の間の値である必要があります。'],
                    'keyword' => ['「keyword」は文字列形式で入力する必要があります。'],
                    'max' => ['「max」は、0と 100の間の値である必要があります。'],
                    'min' => ['「min」は、0と 100の間の値である必要があります。'],
                    'directionType' => ['「direction type」は、数値形式で入力してください。'],
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
            'api_token' => $this->user->api_token
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(404);
    }
}
