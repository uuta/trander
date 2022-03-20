<?php

namespace App\UseCases\NearBySearch;

use App\Http\Models\GooglePlaceId;
use App\Services\Facades\GenerateLocationService;
use App\UseCases\Interfaces\GetRamdomlyFromApiUseCase;
use App\UseCases\RequestCountHistorys\RequestCountHistoryStoreUseCase;
use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;
use App\Services\RequestApis\NearBySearches\NearBySearchRequestApiService;

class NearBySearchGetUseCase implements GetRamdomlyFromApiUseCase
{
    private $body;
    private $oneData;
    private $generateLocationService;
    protected $nearBySearchRequestApiService;

    public function __construct(
        object $request,
        GenerateLocationService $generateLocationService,
        NearBySearchRequestApiService $nearBySearchRequestApiService
    ) {
        $this->request = $request;
        $this->generateLocationService = $generateLocationService;
        $this->nearBySearchRequestApiService = $nearBySearchRequestApiService;
        $this->requestCountHistoryStoreUseCase = new RequestCountHistoryStoreUseCase(new RequestCountHistoryRepository());
    }

    /**
     * Handler method
     *
     * @return ?array
     */
    public function handle(int $user_id, int $type_id): ?array
    {
        // Generate location randomly
        $this->generateLocationService->handle($this->request);

        // Request to NearBySearch
        $this->nearBySearchRequestApiService->request($this->generateLocationService->location, $this->request->keyword);

        $this->_formatResponse();
        $this->_getContentRandomly();

        // Store request count history
        $this->requestCountHistoryStoreUseCase->handle($user_id, $type_id);

        // Store google place id
        $this->_storeGooglePlace();

        // Return
        return $this->_return();
    }

    /**
     * Format response
     *
     * @return void
     */
    private function _formatResponse(): void
    {
        foreach ($this->nearBySearchRequestApiService->response_body as $value) {
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
    private function _getContentRandomly(): void
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
    private function _return(): array
    {
        return $this->oneData;
    }
}
