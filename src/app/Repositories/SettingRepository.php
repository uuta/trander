<?php

namespace App\Repositories;

use App\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostSettingRequest;

class SettingRepository
{
    public function getAll()
    {
        return DB::table('settings')->get();
    }


    /**
     * Get setting by user id
     *
     * @param int $user_id
     * @return ?object
     */
    public function getSetting(int $user_id): ?object
    {
        return DB::table('settings')->select('min_distance', 'max_distance', 'direction_type')->where('user_id', $user_id)->first();
    }

    /**
     * Set setting by user id
     *
     * @param postsettingrequest $request
     * @return void
     */
    public function setSetting(postsettingrequest $request): void
    {
        DB::table('settings')->updateOrInsert(
            [
                'user_id' => $request->userinfo->id
            ],
            [
                'min_distance' => $request['min'],
                'max_distance' => $request['max'],
                'direction_type' => $request['direction_type'],
            ]
        );

        $setting = DB::table('settings')->where('user_id', $request->userinfo->id)->first();

        DB::table('setting_historys')->insert(
            [
                'setting_id' => $setting->id,
                'min_distance' => $request['min'],
                'max_distance' => $request['max'],
                'direction_type' => $request['direction_type'],
            ]
        );
    }
}
