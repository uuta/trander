<?php

namespace App\Services\Hotel;

// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Services\ExternalResponse;

class Get extends ExternalResponse
{
    protected $addedResponse = [
        'key' => [
            ['name' => 'hotelName', 'content' => "['hotel'][0]['hotelBasicInfo']['hotelName']"],
            ['name' => 'hotelInformationUrl', 'content' => "['hotel'][0]['hotelBasicInfo']['hotelInformationUrl']"],
            ['name' => 'hotelMinCharge', 'content' => "['hotel'][0]['hotelBasicInfo']['hotelMinCharge']"],
            ['name' => 'reviewAverage', 'content' => "['hotel'][0]['hotelBasicInfo']['reviewAverage']"],
            ['name' => 'userReview', 'content' => "['hotel'][0]['hotelBasicInfo']['userReview']"],
            ['name' => 'hotelThumbnailUrl', 'content' => "['hotel'][0]['hotelBasicInfo']['hotelThumbnailUrl']"],
        ],
        'response' => 'hotels',
    ];

    /**
     * Request to yahoo! local search API
     */
    public function apiRequest() {
        $client = new Client();
        $sourceUrl = "https://app.rakuten.co.jp/services/api/Travel/SimpleHotelSearch/20170426";
        $this->response = $client->request("GET", $sourceUrl, [
            'query' => [
                'applicationId' => config('services.rakuten_hotel_search.app_id'),
                'affiliateId' => config('services.rakuten_hotel_search.affiliate_id'),
                'latitude' => $this->request->lat,
                'longitude' => $this->request->lng,
                'searchRadius' => 3,
                'datumType' => 1,
                'hotelThumbnailSize' =>3,
            ]
        ]);
    }
}
