<?php

namespace App\Http\Controllers;

use App\Http\Controllers\NormalizedController;
use App\Http\Requests\GooglePlace\GetRequest;
use GuzzleHttp\Exception\BadResponseException;
use App\Services\GooglePlace\Get as GooglePlaceGet;

class GooglePlaceController extends NormalizedController
{
    protected $Calculation;

    public function __construct(GooglePlaceGet $GooglePlaceGet)
    {
        $this->GooglePlaceGet = $GooglePlaceGet;
    }

    public function show(GetRequest $request)
    {
        $this->normarize_request($request);
        return $this->normarize_response($this->GooglePlaceGet->get_google_place($request->place_id));
    }
}
