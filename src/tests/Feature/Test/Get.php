<?php

namespace Tests\Feature\PlaceInfo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Get extends TestCase
{
    /**
     * 正常
     * @test
     */
    public function should_test_APIへのリクエストに成功する()
    {
        $this->test_weather();
    }

    /**
     * 正常
     */
    private function test_wiki()
    {
        $request = [];
        $response = $this->get(route('test.wiki.get'), $request);
        // レスポンスの中身の確認
        $data = $response->json(['entities']['Q1134006']);
        var_dump($data);

        $response->assertStatus(200);
    }

    /**
     * 正常
     */
    private function test_weather()
    {
        $request = [];
        $response = $this->get(route('test.weather.get'), $request);
        // レスポンスの中身の確認
        $data = $response->json();
        dd($data);

        $response->assertStatus(200);
    }
}
