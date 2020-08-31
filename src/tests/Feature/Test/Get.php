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
        $request = [];
        $response = $this->get(route('test.get'), $request);

        // レスポンスの中身の確認
        // $data = $response->json(['list']);
        $data = $response->json(['hotels']);
        dd($data);

        $response->assertStatus(200);
    }
}
