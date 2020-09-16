<?php

namespace Tests\Feature\Facility;

use Tests\LoginTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\RequestCountHistory;

class GetTest extends LoginTestCase
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
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(100, $data);
        $value = array_shift($data);
        $this->assertArrayHasKey('name', $value);
        $this->assertArrayHasKey('genre', $value);
        $this->assertArrayHasKey('rating', $value);
        $this->assertArrayHasKey('leadImage', $value);

        // Make sure imported record
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $this->user->id,
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
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['「lat」フィールドの入力は必須です。'],
                    'lng' => ['「lng」フィールドの入力は必須です。'],
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
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['「lat」は、-90と90の間の値である必要があります。'],
                    'lng' => ['「lng」は、-180と180の間の値である必要があります。'],
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
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(404);
    }
}
