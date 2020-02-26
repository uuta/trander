<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckRepository
{
  protected $table = 'users';

  public function getAll()
  {
    return DB::table($this->table)->get();
  }

  /**
   * usersテーブルのcheck_registrationを0に変更する
   */
  public function changeRegistration() {
    DB::table($this->table)->updateOrInsert(
      [
        'id' => Auth::id()
      ],
      [
        'check_registration' => false,
      ]
    );
  }
}
