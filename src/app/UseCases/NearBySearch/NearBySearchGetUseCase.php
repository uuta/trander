<?php

namespace App\UseCases\NearBySearch;

use App\Http\Models\GooglePlaceId;
use App\Http\Models\RequestCountHistory;
use App\Services\Facades\GenerateLocationService;
use App\UseCases\Interfaces\GetRamdomlyFromApiUseCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\UseCases\RequestCountHistorys\RequestCountHistoryStoreUseCase;
use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;
use App\Services\RequestApis\NearBySearches\NearBySearchRequestApiService;

class NearBySearchGetUseCase implements GetRamdomlyFromApiUseCase
{
    private $body;
    private $response;
    private $oneData;
    private $generateLocationService;
    private $nearBySearchRequestApiService;

    public function __construct(object $request)
    {
        $this->request = $request;
        $this->generateLocationService = new GenerateLocationService($request);
        $this->nearBySearchRequestApiService = new NearBySearchRequestApiService();
        $this->requestCountHistoryStoreUseCase = new RequestCountHistoryStoreUseCase(new RequestCountHistoryRepository(), RequestCountHistory::TYPE_ID['getNearBySearch'], $request->all()['userinfo']->id);
    }

    /**
     * Handler method
     *
     * @return ?array
     */
    public function handle(): ?array
    {
        $this->_generateLocation();
        $this->_apiRequest();
        $this->_verifyEmpty();
        $this->_formatResponse();
        $this->_getContentRandomly();

        // Store request count history
        $this->requestCountHistoryStoreUseCase->handle();

        // Store google place id
        $this->_storeGooglePlace();

        // Return
        return $this->_return();
    }

    /**
     * Generate a location
     *
     * @return void
     */
    public function _generateLocation()
    {
        $this->location = $this->generateLocationService->generateLocation();
    }

    /**
     * Request to Google Near By Search API
     * It doesn't need to return a response in general, but it requires a response for error handling
     *
     * @return void
     */
    public function _apiRequest(): void
    {
        $this->response = $this->nearBySearchRequestApiService->request($this->location, $this->request->keyword);
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
     * Store google place id
     *
     * @return void
     */
    private function _storeGooglePlace(): void
    {
        GooglePlaceId::insert_information($this->oneData);
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
