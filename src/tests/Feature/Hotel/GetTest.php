<?php

namespace Tests\Feature\Hotel;

use Tests\LoginTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\RequestCountHistory;

class GetTest extends LoginTestCase
{
    private const ROUTE = 'hotel.get';

    /**
     * 正常
     * @test
     */
    public function should_hotel_APIへのリクエストに成功する()
    {
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
            'apiToken' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(30, $data);
        $value = array_shift($data);
        $this->assertArrayHasKey('hotelName', $value);
        $this->assertArrayHasKey('hotelInformationUrl', $value);
        $this->assertArrayHasKey('hotelMinCharge', $value);
        $this->assertArrayHasKey('reviewAverage', $value);
        $this->assertArrayHasKey('userReview', $value);
        $this->assertArrayHasKey('hotelThumbnailUrl', $value);

        // Make sure imported record
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $this->user->id,
            'type_id' => RequestCountHistory::TYPE_ID['getSimpleHotelSearch'],
        ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_hotel_APIへのリクエストが失敗する（バリデーション）（空）()
    {
        // Empty parameter
        $request = [
            'apiToken' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['The lat field is required.'],
                    'lng' => ['The lng field is required.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_hotel_APIへのリクエストが失敗する（バリデーション）（最大・最小値）()
    {
        // Uncorrected parameter
        $request = [
            'lat' => 200,
            'lng' => 500,
            'api_token' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['The lat must be between -90 and 90.'],
                    'lng' => ['The lng must be between -180 and 180.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_hotel_APIへのリクエストが失敗する（404）()
    {
        $request = [
            'lat' => 36.010887,
            'lng' => 140.301335,
            'api_token' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(404);
    }
}
