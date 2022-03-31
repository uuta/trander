<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RequestLimits\RestoreRequestLimitService;
use App\Repositories\RequestLimits\RequestLimitRepository;

class RequestLimitController extends Controller
{
    public function put(
        Request $request,
        RestoreRequestLimitService $restoreRequestLimitService
    ) {
        $restoreRequestLimitService->handle();
    }
}
