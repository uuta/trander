<?php

namespace App\Repositories;

use App\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingRepository
{
  protected $table = 'settings';

  public function getAll()
  {
    return DB::table($this->table)->get();
  }

  public function getSetting()
  {
    return DB::table($this->table)->select('min_distance', 'max_distance', 'direction_type')->where('user_id', Auth::id())->first();
  }

  public function setSetting($request)
  {
    DB::table($this->table)->updateOrInsert(
      [
        'user_id' => Auth::id()
      ],
      [
        'min_distance' => $request['lat'],
        'max_distance' => $request['lng'],
        'direction_type' => $request['direction_type'],
      ]
    );
  }
}
