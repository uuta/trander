<?php

namespace Tests\Feature\NearBySearch;

use Tests\LoginTestCase;
use App\RequestCountHistory;

class GetTest extends LoginTestCase
{
    private const ROUTE = 'near-by-search.get';

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
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(7, $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('icon', $data);
        $this->assertArrayHasKey('rating', $data);
        $this->assertArrayHasKey('photo', $data);
        $this->assertArrayHasKey('vicinity', $data);
        $this->assertArrayHasKey('userRatingsTotal', $data);
        $this->assertArrayHasKey('priceLevel', $data);

        // Make sure imported record
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
        $request = [];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['「lat」フィールドの入力は必須です。'],
                    'lng' => ['「lng」フィールドの入力は必須です。'],
                    'keyword' => ['「keyword」フィールドの入力は必須です。'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_near_by_search_APIへのリクエストが失敗する（バリデーション）（最大・最小値）()
    {
        // Uncorrected parameter
        $request = [
            'lat' => 200,
            'lng' => 500,
            'keyword' => 22,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'lat' => ['「lat」は、-90と90の間の値である必要があります。'],
                    'lng' => ['「lng」は、-180と180の間の値である必要があります。'],
                    'keyword' => ['「keyword」は文字列形式で入力する必要があります。'],
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
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(404);
    }
}
