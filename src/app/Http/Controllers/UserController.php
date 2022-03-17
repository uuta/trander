<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\CreateUserRequest;

class UserController extends Controller
{
    /**
     * GET /api/user
     *
     * @param Request $request
     * @return User|null
     */
    public function show(Request $request): ?User
    {
        return User::where('unique_id', $request->auth0_sub)->first();
    }

    /**
     * POST /api/user
     *
     * @param CreateUserRequest $request
     * @return void
     */
    public function create(CreateUserRequest $request): void
    {
        User::firstOrCreate(['unique_id' => $request->auth0_sub]);
    }
}
