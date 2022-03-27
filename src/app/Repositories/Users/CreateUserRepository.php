<?php

namespace App\Repositories\Users;

use App\Http\Models\User;
use App\Http\Models\RequestLimit;

class CreateUserRepository
{
    /**
     * Store user and request limit
     *
     * @param string $unique_id
     * @return User
     */
    public function store(string $unique_id): User
    {
        $user = User::firstOrCreate(['unique_id' => $unique_id]);
        if ($user->wasRecentlyCreated) {
            RequestLimit::firstOrCreate(['user_id' => $user->id]);
        }
        return $user;
    }
}
