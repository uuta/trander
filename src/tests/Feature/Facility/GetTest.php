<?php

namespace Tests\Feature\Facility;

use App\User;
use Tests\SetUpTestCase;
use App\RequestCountHistory;

class GetTest extends SetUpTestCase
{
    private const ROUTE = 'facility.get';

    /**
     * 正常
     * @test
     */
    public function should_facility_APIへのリクエストに成功する()
    {
        $request = [
            'lat' => 43.067883,
            'lng' => 141.322995,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(100, $data);
        $value = array_shift($data);
        $this->assertArrayHasKey('name', $value);
        $this->assertArrayHasKey('genre', $value);
        $this->assertArrayHasKey('code', $value);
        $this->assertArrayHasKey('rating', $value);
        $this->assertArrayHasKey('leadImage', $value);

        // Make sure imported record
        $user = User::where('email', config('const.test.email'))->first();
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $user->id,
            'type_id' => RequestCountHistory::TYPE_ID['getYahooLocalSearch'],
        ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_facility_APIへのリクエストが失敗する（バリデーション）（空）()
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
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_facility_APIへのリクエストが失敗する（バリデーション）（最大・最小値）()
    {
        // Uncorrected parameter
        $request = [
            'lat' => 200,
            'lng' => 500,
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
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_facility_APIへのリクエストが失敗する（404）()
    {
        $request = [
            'lat' => 36.676576,
            'lng' => 150.121322,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(404);
    }
}
