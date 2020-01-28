<?php

namespace Tests\Feature;

use App\Setting;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function should_setting_APIへのリクエストに成功する()
    {
        // テストユーザ作成
        $this->setting = factory(Setting::class)->states('register user and safe distance')->create();

        // 作成したテストユーザ検索
        $user = DB::table('users')->where('id', $this->setting->user_id)->first();

        // ログイン
        $response_test = $this->json('POST', route('login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);
        $response_test->assertStatus(200);

        // setting_APIにリクエストして成功する
        $response = $this->post(route('setting'));
        $response
            ->assertStatus(200)
            ->assertJson([
                'user_id' => $this->setting->user_id,
                'min_distance' => $this->setting->min_distance,
                'max_distance' => $this->setting->max_distance
            ]);
    }
}
