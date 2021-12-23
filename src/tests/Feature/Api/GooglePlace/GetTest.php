<?php

namespace Tests\Feature\Api\GooglePlace;

use Tests\SetUpTestCase;
use App\GooglePlaceId;

class GetTest extends SetUpTestCase
{
    private const ROUTE = 'google-place.get';
    private const ID = 'ChIJrxB0hPyFGGARiBrTkA2Xd3I';

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('GooglePlaceIdsSeeder');
    }

    /**
     * 正常
     * @test
     */
    public function should_google_place_APIへのリクエストに成功する()
    {
        $request = [
            'placeId' => $this::ID,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);

        // Get rows with request id
        $value = GooglePlaceId::where('place_id', $this::ID)->first();

        // Make sure the response data
        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $value->name,
                'icon' => $value->icon,
                'rating' => $value->rating,
                'photo' => $value->photo,
                'vicinity' => $value->vicinity,
                'userRatingsTotal' => $value->user_ratings_total,
                'priceLevel' => $value->price_level,
                'lat' => $value->lat,
                'lng' => $value->lng,
                'ratingStar' => $value->rating_star,
            ]);

        $data = $response->json();
        $this->assertCount(10, $data);
    }

    /**
     * 準正常
     * @test
     */
    public function should_google_place_APIに存在しないidを送信しリクエストが失敗する（404）()
    {
        // Not exist id
        $request = [
            'placeId' => 'Unfortunately, this id doesn\'t exist',
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(404);
    }

    /**
     * 準正常
     * @test
     */
    public function should_google_place_APIへのリクエストが失敗する（バリデーション）（空）()
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
                    'placeId' => ['The place id field is required.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_google_place_APIへのリクエストが失敗する（バリデーション）（値）()
    {
        // Uncorrected parameter
        $request = [
            'placeId' => 200,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'placeId' => ['The place id must be a string.'],
                ]
            ]);
    }
}
