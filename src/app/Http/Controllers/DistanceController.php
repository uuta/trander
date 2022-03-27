<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Distance\GetRequest;
use App\Services\Distance\Get as GetDistance;

class DistanceController extends Controller
{
    public function index(GetRequest $request)
    {
        $GetDistance = new GetDistance($request);
        $GetDistance->getAngle();
        return $GetDistance->getResponse();
    }
}
