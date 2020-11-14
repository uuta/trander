<?php

namespace App\Services\NearBySearch;

use GuzzleHttp\Client;
use App\Services\Factries\ExternalResponse\ExternalResponseFactory;
use App\Services\Factries\ExternalResponse\Base;

class Get extends ExternalResponseFactory
{
    public function __construct(object $request, string $location)
    {
        $this->request = $request;
        $this->location = $location;
    }

    protected $addedResponse = [
        'key' => [
            ['name' => 'name', 'content' => "['name']"],
            ['name' => 'icon', 'content' => "['icon']"],
            ['name' => 'rating', 'content' => "['rating']"],
            ['name' => 'photo', 'content' => "['photos'][0]['photo_reference']"],
            ['name' => 'vicinity', 'content' => "['vicinity']"],
            ['name' => 'user_ratings_total', 'content' => "['user_ratings_total']"],
            ['name' => 'price_level', 'content' => "['price_level']"],
            ['name' => 'lat', 'content' => "['geometry']['location']['lat']"],
            ['name' => 'lng', 'content' => "['geometry']['location']['lng']"],
            ['name' => 'place_id', 'content' => "['place_id']"],
        ],
        'response' => 'results',
        'hierarchy' => ExternalResponseFactory::HIERARCHY['second'],
        'processing' => [
            ['name' => 'rating_star', 'key_name' => 'rating', 'type' => Base::PROCESSING['RATING']],
        ],
    ];

    /**
     * Request to Google Near By Search API
     * It doesn't need to return a response in general, but it requires a response for error handling
     *
     * @return object
     */
    public function apiRequest() : object
    {
        $client = new Client();
        $sourceUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json";
        $this->response = $client->request("GET", $sourceUrl, [
            'query' => [
                'key' => config('services.google_places.key'),
                'location' => $this->location,
                'radius' => 5000,
                'keyword' => $this->request->keyword,
                'language' => 'ja',
            ]
        ]);
        return $this->response;
    }

    /**
     * Get a content randomly from response
     *
     * @param array $response
     * @return array
     */
    public function get_content_randomly(array $response) : array
    {
        if (!empty($response)) {
            $index = array_rand($response);
            return $response[$index];
        }
        return $response;
    }
}
