<?php

namespace App\UseCases\NearBySearch;

use GuzzleHttp\Client;
use App\UseCases\Interfaces\GetRamdomlyFromApiUseCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NearBySearchGetUseCase implements GetRamdomlyFromApiUseCase
{
    private $body;
    private $response;
    private $oneData;

    public function __construct(object $request, string $location)
    {
        $this->request = $request;
        $this->location = $location;
    }

    /**
     * Handler method
     *
     * @return ?array
     */
    public function handle(): ?array
    {
        $this->_apiRequest();
        $this->_verifyEmpty();
        $this->_formatResponse();
        $this->_getContentRandomly();
        return $this->_return();
    }

    /**
     * Request to Google Near By Search API
     * It doesn't need to return a response in general, but it requires a response for error handling
     *
     * @return void
     */
    public function _apiRequest(): void
    {
        $client = new Client();
        $sourceUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json";
        $this->response = $client->request("GET", $sourceUrl, [
            'query' => [
                'key' => config('services.google_places.key'),
                'location' => $this->location,
                'radius' => 5000,
                'keyword' => $this->request->keyword,
                'language' => 'en',
            ]
        ]);
    }

    /**
     * Verify the response and format it
     *
     * @throws ModelNotFoundException
     * @return void
     */
    public function _verifyEmpty(): void
    {
        if (empty(json_decode($this->response->getBody(), true)['results'])) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * Format response
     *
     * @return void
     */
    public function _formatResponse(): void
    {
        $response = json_decode($this->response->getBody(), true);
        foreach ($response['results'] as $value) {
            $this->body[] = [
                'name' => $value['name'] ?? '',
                'icon' => $value['icon'] ?? '',
                'rating' => $value['rating'] ?? null,
                'photo' => $value['photos'][0]['photo_reference'] ?? '',
                'vicinity' => $value['vicinity'] ?? '',
                'user_ratings_total' => $value['user_ratings_total'] ?? 0,
                'price_level' => $value['price_level'] ?? 0,
                'lat' => (float) round($value['geometry']['location']['lat'], 7) ?? 0,
                'lng' => (float) round($value['geometry']['location']['lng'], 7) ?? 0,
                'place_id' => $value['place_id'] ?? '',
                'rating_star' => ''
            ];
        }
    }

    /**
     * Get a content randomly from response
     *
     * @return void
     */
    public function _getContentRandomly(): void
    {
        $index = array_rand($this->body);
        $this->oneData = $this->body[$index];
    }

    /**
     * Return data
     *
     * @return array
     */
    public function _return(): array
    {
        return $this->oneData;
    }
}
