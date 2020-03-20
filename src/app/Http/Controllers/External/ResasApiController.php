<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;

class ResasApiController extends Controller
{
  public function request()
  {
    $client = new Client();
    $sourceUrl = "https://opendata.resas-portal.go.jp/api/v1/prefectures";
    $responseData = $client->request("GET", $sourceUrl, array(
      'headers' => array(
        'X-API-KEY' => env('RESAS_API'),
        'Content-Type' => 'application/json;charset=UTF-8'
      ),
    ));
    $responseBody = json_decode($responseData->getBody()->getContents(), true);
    return [
      "status" => "OK",
      "data" => $responseBody,
    ];
  }
}
