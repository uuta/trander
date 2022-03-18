<?php

namespace App\Repositories;

use App\Http\Models\User;
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
    public function changeRegistration()
    {
        DB::table($this->table)->updateOrInsert(
            [
                'api_token' => Auth::id()
            ],
            [
                'check_registration' => User::REGISTERED,
            ]
        );
    }
}
