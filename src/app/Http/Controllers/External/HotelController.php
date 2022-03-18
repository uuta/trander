<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use App\Http\Controllers\NormalizedController;
use App\Http\Requests\Hotel\GetRequest;
use App\Services\Hotel\Get as HotelGet;
use GuzzleHttp\Exception\BadResponseException;
use App\Http\Models\RequestCountHistory;

class HotelController extends NormalizedController
{
    public function index(GetRequest $request)
    {
        try {
            $this->normarize_request($request);

            // Request
            $HotelGet = new HotelGet($request);
            $HotelGet->apiRequest();
            $GetResponse = $HotelGet->getResponse();
            $response = $GetResponse->formatResponse();

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getSimpleHotelSearch'], $request->all()['userinfo']->id);

            return $this->normarize_multiple_response($response);
        } catch (BadResponseException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, $e->getResponse()->getStatusCode());
        }
    }
}
