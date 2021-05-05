<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NormalizedController;
use App\Http\Requests\Distance\GetRequest;
use App\Services\Distance\Get as GetDistance;

class DistanceController extends NormalizedController
{
    //
    public function index(GetRequest $request)
    {
        $GetDistance = new GetDistance($request);
        $GetDistance->get_angle();
        $response = $GetDistance->get_response();

        return $this->normarize_response($response);
    }
}
