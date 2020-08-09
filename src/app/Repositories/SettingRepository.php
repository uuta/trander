<?php

namespace App\Repositories;

use App\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingRepository
{
    public function getAll()
    {
        return DB::table('settings')->get();
    }

    public function getSetting()
    {
        return DB::table('settings')->select('min_distance', 'max_distance', 'direction_type')->where('user_id', Auth::id())->first();
    }

    public function setSetting($request)
    {

        DB::table('settings')->updateOrInsert(
            [
                'user_id' => Auth::id()
            ],
            [
                'min_distance' => $request['min'],
                'max_distance' => $request['max'],
                'direction_type' => $request['direction_type'],
            ]
        );

        $setting = DB::table('settings')->where('user_id', Auth::id())->first();

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
