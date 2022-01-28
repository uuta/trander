<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use App\Http\Controllers\NormalizedController;
use GuzzleHttp\Exception\BadResponseException;
use App\Services\Wiki\GetCity as WikiCityGet;
use App\Http\Requests\Wiki\GetCityRequest;
use App\RequestCountHistory;

class WikiController extends NormalizedController
{
    public function city_index(GetCityRequest $request)
    {
        try {
            // Request
            $WikiGet = new WikiCityGet($request);
            $WikiGet->apiRequest();
            $response = $WikiGet->formatResponse();

            // Insert a request history
            (new RequestCountHistory())->setHistory(RequestCountHistory::TYPE_ID['getWikidata'], $request->all()['userinfo']->id);

            return $response;
        } catch (BadResponseException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, $e->getResponse()->getStatusCode());
        }
    }
}
