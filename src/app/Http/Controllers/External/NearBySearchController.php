<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\NormalizedController;
use App\Http\Requests\NearBySearch\GetRequest;
use App\Services\NearBySearch\Get as NearBySearchGet;
use GuzzleHttp\Exception\BadResponseException;
use App\Services\Facades\GenerateLocation;
use App\GooglePlaceId;
use App\RequestCountHistory;

class NearBySearchController extends NormalizedController
{
    public function index(GetRequest $request)
    {
        try
        {
            $this->normarize_request($request);

            // Generate location
            $Randomization = new GenerateLocation($request);
            $location = $Randomization->generate_location();

            // Request
            $NearBySearchGet = new NearBySearchGet($request, $location);
            $NearBySearchGetResponse = $NearBySearchGet->apiRequest();
            $decodeResponse = json_decode($NearBySearchGetResponse->getBody(), true);

            // Error handling
            if(empty($decodeResponse['results'])) {
                return response()->json($decodeResponse, 404);
            }

            $GetResponse = $NearBySearchGet->get_response();
            $response = $GetResponse->formatResponse();
            $oneResponse = $NearBySearchGet->get_content_randomly($response);

            // Insert into google_place_ids
            GooglePlaceId::insert_information($oneResponse);

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getNearBySearch']);

            return $this->normarize_response($oneResponse);
        }
        catch (BadResponseException $e)
        {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, $e->getResponse()->getStatusCode());
        }
    }
}
