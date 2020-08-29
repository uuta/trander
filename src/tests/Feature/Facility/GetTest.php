<?php

namespace Tests\Feature\Facility;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\RequestCountHistory;

class GetTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'facility.get';

    public function setUp()
    {
        parent::setUp();

        // Make a test user
        $this->user = factory(User::class)->create();
        $login = $this->json('POST', route('login'), [
            'email' => $this->user->email,
            'password' => 'secret',
        ]);
        $login->assertStatus(200);
    }

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
        $data = $response->json(['data']);
        $this->assertCount(100, $response->json(['data']));
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
}
