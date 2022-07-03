<?php

namespace Tests\Feature\Api\Backpacker\Cities;

use Tests\SetUpTestCase;

class BackpackerCitiesIndexTest extends SetUpTestCase
{
    private const ROUTE = 'backpacker.cities.get';

    /**
     * 正常
     * @test
     */
    public function should_BackpackerCities_APIへのリクエストに成功する()
    {
        // 仮の指定地点をリクエストパラメーターに設定
        $request = [];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // レスポンスの中身の確認
        $data = $response->json(['data']);
        $this->assertCount(8, $data);
        $this->assertIsString($data['countryCode']);
        $this->assertIsString($data['city']);
        $this->assertIsString($data['region']);
        $this->assertIsFloat(round($data['distance']));
    }
}
