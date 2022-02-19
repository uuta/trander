<?php

namespace Tests\Feature\Api\Wiki;

use App\User;
use Tests\SetUpTestCase;
use App\RequestCountHistory;

class GetCityTest extends SetUpTestCase
{
    private const ROUTE = 'wiki.city.get';

    /**
     * 正常
     * @test
     */
    public function should_city_wiki_APIへのリクエストに成功する()
    {
        $request = [
            'wikiId' => 'Q237',
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(3, $data);
        $this->assertArrayHasKey('population', $data);
        $this->assertArrayHasKey('area', $data);
        $this->assertArrayHasKey('inception', $data);

        // Make sure imported record
        $user = User::where('email', config('const.test.email'))->first();
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $user->id,
            'type_id' => RequestCountHistory::TYPE_ID['getWikidata'],
        ]);
    }

    /**
     * 正常
     * @test
     */
    public function should_city_wiki_APIへのリクエストに成功する（国内）()
    {
        $request = [
            'wikiId' => 'Q817271',
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // Make sure response data
        $data = $response->json();
        $this->assertCount(3, $data);
        $this->assertArrayHasKey('population', $data);
        $this->assertArrayHasKey('area', $data);
        $this->assertArrayHasKey('inception', $data);

        // Make sure imported record
        $user = User::where('email', config('const.test.email'))->first();
        $this->assertDatabaseHas('request_count_historys', [
            'user_id' => $user->id,
            'type_id' => RequestCountHistory::TYPE_ID['getWikidata'],
        ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_city_wiki_APIへのリクエストが失敗する（バリデーション）（空）()
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
                    'wikiId' => ['The wiki id field is required.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_city_wiki_APIへのリクエストが失敗する（バリデーション）（最大・最小値）()
    {
        // Uncorrected parameter
        $request = [
            'wikiId' => 200,
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'wikiId' => ['The wiki id must be a string.'],
                ]
            ]);
    }

    /**
     * 準正常
     * @test
     */
    public function should_city_wiki_APIへのリクエストが失敗する（400）()
    {
        $request = [
            'wikiId' => 'Q739718973891789',
        ];
        $response = $this->call('GET', route($this::ROUTE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(400);
    }
}
