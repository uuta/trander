<?php

namespace App\Repositories;

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
    return DB::table($this->table)->where('user_id', Auth::id())->first();
  }

  public function setSetting()
  {
    DB::updateOrCreate(
      [
        'user_id' => 9
      ],
      [
        'min_distance' => 10,
        'max_distance' => 33
      ]
    );
  }
}
