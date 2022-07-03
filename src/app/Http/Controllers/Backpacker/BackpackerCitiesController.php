<?php

namespace App\Http\Controllers\Backpacker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UseCases\Backpackers\BackpackerCitiesUseCase;


class BackpackerCitiesController extends Controller
{
    public function index(Request $request)
    {
        return (new BackpackerCitiesUseCase($request))->handle();
    }
}
