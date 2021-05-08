<?php

namespace App\Http\Controllers;

use App\Repositories\CheckRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $user = User::where('api_token', $request->get('api_token'))->first();
        $user->check_registration = User::REGISTERED;
        $user->save();
    }
}
