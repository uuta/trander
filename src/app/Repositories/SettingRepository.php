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
}
