<?php

namespace Tests\Feature;

use App\Setting;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
    public function should_setting_getにリクエストして正しいレスポンスが返る()
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

        // setting_get_APIにリクエストして成功する
        $response = $this->get(route('setting.get'));
        $response
            ->assertStatus(200)
            ->assertJson([
                'min_distance' => $this->setting->min_distance,
                'max_distance' => $this->setting->max_distance,
                'direction_type' => $this->setting->direction_type,
            ]);
    }

    /**
     * @test
     */
    public function should_setting_storeにリクエストしてデータが保存される（作成）()
    {
        // テストユーザ作成
        $this->user = factory(User::class)->create();

        // ログイン
        $response_test = $this->json('POST', route('login'), [
            'email' => $this->user->email,
            'password' => 'secret',
        ]);
        $response_test->assertStatus(200);

        $distance = [
            'min' => 15,
            'max' => 33,
            'direction_type' => Setting::DIRECTION_TYPE['north'],
        ];
        // setting_post_APIにリクエストして成功する
        $response = $this->post(route('setting.get'), $distance);
        $response->assertStatus(200);

        // データが保存されていることを確認する
        $this->assertDatabaseHas('settings', [
            'user_id' => $this->user->id,
            'min_distance' => $distance['min'],
            'max_distance' => $distance['max'],
            'direction_type' => $distance['direction_type'],
        ]);

        $setting = DB::table('settings')->where('user_id', $this->user->id)->first();

        $this->assertDatabaseHas('setting_historys', [
            'setting_id' => $setting->id,
            'min_distance' => $distance['min'],
            'max_distance' => $distance['max'],
            'direction_type' => $distance['direction_type'],
        ]);
    }

    /**
     * @test
     */
    public function should_setting_storeにリクエストしてデータが保存される（更新）()
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

        $distance = [
            'min' => $this->setting->min_distance,
            'max' => $this->setting->max_distance,
            'direction_type' => $this->setting->direction_type,
        ];
        // setting_post_APIにリクエストして成功する
        $response = $this->post(route('setting.get'), $distance);
        $response->assertStatus(200);

        // データが保存されていることを確認する
        $this->assertDatabaseHas('settings', [
            'user_id' => $this->setting->user_id,
            'min_distance' => $this->setting->min_distance,
            'max_distance' => $this->setting->max_distance,
            'direction_type' => $this->setting->direction_type,
        ]);

        $setting = DB::table('settings')->where('user_id', $this->setting->user_id)->first();

        $this->assertDatabaseHas('setting_historys', [
            'setting_id' => $setting->id,
            'min_distance' => $distance['min'],
            'max_distance' => $distance['max'],
            'direction_type' => $distance['direction_type'],
        ]);
    }
}
