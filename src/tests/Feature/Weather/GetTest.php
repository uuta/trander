<?php

namespace Tests\Feature\Weather;

use Tests\LoginTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\RequestCountHistory;

class GetTest extends LoginTestCase
{
    private const ROUTE = 'weather.get';

    /**
     * 正常
     * @test
     */
    public function should_weather_APIへのリクエストに成功する()
    {
        $request = [
            'lat' => 28.028910,
            'lng' => 86.780009,
            'apiToken' => $this->user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(40, $data);
        $value = array_shift($data);
        $this->assertArrayHasKey('temp', $value);
        $this->assertArrayHasKey('description', $value);
        $this->assertArrayHasKey('weatherIcon', $value);
        $this->assertArrayHasKey('dateTime', $value);
        $this->assertArrayHasKey('rain', $value);
        $this->assertArrayHasKey('snow', $value);

        // Make sure imported record
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $this->user->id,
            'type_id' => RequestCountHistory::TYPE_ID['getCurrentWeather'],
        ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_weather_APIへのリクエストが失敗する（バリデーション）（空）()
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
                    'lat' => ['「lat」フィールドの入力は必須です。'],
                    'lng' => ['「lng」フィールドの入力は必須です。'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_weather_APIへのリクエストが失敗する（バリデーション）（最大・最小値）()
    {
        // Uncorrected parameter
        $request = [
            'lat' => 200,
            'lng' => 500,
            'apiToken' => $this->user->api_token,
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
