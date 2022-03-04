<?php

namespace App\Http\Controllers;

use App\Repositories\CheckRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CheckController extends Controller
{
    protected $CheckRepository;

    public function __construct(CheckRepository $CheckRepository)
    {
        $this->CheckRepository = $CheckRepository;
    }

    public function changeRegistration(Request $request)
    {
        $user = User::where('unique_id', $request->get('auth0_sub'))->first();
        $user->check_registration = User::REGISTERED;
        $user->save();
    }
}
