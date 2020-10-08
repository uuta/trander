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
        $this->near_by_search();
    }

    /**
     * 正常
     */
    private function wiki()
    {
        $request = [];
        $response = $this->get(route('test.wiki.get'), $request);
        $data = $response->json(['entities']['Q1134006']);
        var_dump($data);

        $response->assertStatus(200);
    }

    /**
     * 正常
     */
    private function weather()
    {
        $request = [];
        $response = $this->get(route('test.weather.get'), $request);
        $data = $response->json();
        dd($data);

        $response->assertStatus(200);
    }

    /**
     * 正常
     */
    private function find_place()
    {
        $request = [];
        $response = $this->get(route('test.find-place.get'), $request);
        $data = $response->json();
        dd($data);

        $response->assertStatus(200);
    }

    /**
     * 正常
     */
    private function near_by_search()
    {
        $request = [];
        $response = $this->get(route('test.near-by-search.get'), $request);
        $data = $response->json();
        dd($data);

        $response->assertStatus(200);
    }
}
