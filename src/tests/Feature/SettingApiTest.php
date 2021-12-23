<?php

namespace Tests\Feature;

use App\Setting;
use App\User;
use Tests\SetUpTestCase;
use Illuminate\Support\Facades\DB;

class SettingApiTest extends SetUpTestCase
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
        $request = [];
        $response = $this->call('GET', route($this::ROUTE_GET), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'minDistance' => $this->setting->min_distance,
                'maxDistance' => $this->setting->max_distance,
                'directionType' => $this->setting->direction_type,
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
            'directionType' => Setting::DIRECTION_TYPE['north'],
        ];
        $response = $this->call('POST', route($this::ROUTE_STORE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
        $response->assertStatus(200);

        // データが保存されていることを確認する
        $user = User::where('email', config('const.test.email'))->first();
        $this->assertDatabaseHas('settings', [
            'user_id' => $user->id,
            'min_distance' => $request['min'],
            'max_distance' => $request['max'],
            'direction_type' => $request['directionType'],
        ]);

        $setting = DB::table('settings')->where('user_id', $user->id)->first();
        $this->assertDatabaseHas('setting_historys', [
            'setting_id' => $setting->id,
            'min_distance' => $request['min'],
            'max_distance' => $request['max'],
            'direction_type' => $request['directionType'],
        ]);
    }

    /**
     * @test
     */
    public function should_setting_storeにリクエストしてデータが保存される（更新）()
    {
        // テストユーザ作成
        $setting = factory(Setting::class)->states('register user and safe distance')->create();

        $request = [
            'min' => $setting->min_distance,
            'max' => $setting->max_distance,
            'directionType' => $setting->direction_type,
        ];
        // setting_post_APIにリクエストして成功する
        $response = $this->call('POST', route($this::ROUTE_STORE), $request, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]);
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
            'direction_type' => $request['directionType'],
        ]);
    }
}
