<?php

namespace Tests\Feature;

use App\Setting;
use App\User;
use Tests\LoginTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class SettingApiTest extends LoginTestCase
{
    private const ROUTE_GET = 'setting.get';
    private const ROUTE_STORE = 'setting.store';

    /**
     * @test
     */
    public function should_setting_getにリクエストして正しいレスポンスが返る()
    {
        // テストユーザ作成
        $this->setting = factory(Setting::class)->states('register user and safe distance')->create();

        // 作成したテストユーザ検索
        $user = DB::table('users')->where('id', $this->setting->user_id)->first();

        // setting_get_APIにリクエストして成功する
        $request = [
            'api_token' => $user->api_token,
        ];
        $response = $this->call('GET', route($this::ROUTE_GET), $request);
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
        // setting_post_APIにリクエストして成功する
        $request = [
            'min' => 15,
            'max' => 33,
            'direction_type' => Setting::DIRECTION_TYPE['north'],
            'api_token' => $this->user->api_token,
        ];
        $response = $this->call('POST', route($this::ROUTE_STORE), $request);
        $response->assertStatus(200);

        // データが保存されていることを確認する
        $this->assertDatabaseHas('settings', [
            'user_id' => $this->user->id,
            'min_distance' => $request['min'],
            'max_distance' => $request['max'],
            'direction_type' => $request['direction_type'],
        ]);

        $setting = DB::table('settings')->where('user_id', $this->user->id)->first();

        $this->assertDatabaseHas('setting_historys', [
            'setting_id' => $setting->id,
            'min_distance' => $request['min'],
            'max_distance' => $request['max'],
            'direction_type' => $request['direction_type'],
        ]);
    }

    /**
     * @test
     */
    public function should_setting_storeにリクエストしてデータが保存される（更新）()
    {
        // テストユーザ作成
        $setting = factory(Setting::class)->states('register user and safe distance')->create();

        // 作成したテストユーザ検索
        $user = DB::table('users')->where('id', $setting->user_id)->first();

        $request = [
            'min' => $setting->min_distance,
            'max' => $setting->max_distance,
            'direction_type' => $setting->direction_type,
            'api_token' => $user->api_token,
        ];
        // setting_post_APIにリクエストして成功する
        $response = $this->call('POST', route($this::ROUTE_STORE), $request);
        $response->assertStatus(200);

        // データが保存されていることを確認する
        $this->assertDatabaseHas('settings', [
            'user_id' => $setting->user_id,
            'min_distance' => $setting->min_distance,
            'max_distance' => $setting->max_distance,
            'direction_type' => $setting->direction_type,
        ]);

        $setting = DB::table('settings')->where('user_id', $setting->user_id)->first();

        $this->assertDatabaseHas('setting_historys', [
            'setting_id' => $setting->id,
            'min_distance' => $request['min'],
            'max_distance' => $request['max'],
            'direction_type' => $request['direction_type'],
        ]);
    }
}
