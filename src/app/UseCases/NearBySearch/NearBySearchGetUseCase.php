<?php

namespace App\UseCases\NearBySearch;

use App\Http\Models\GooglePlaceId;
use App\Services\Facades\GenerateLocationService;
use App\Services\Contents\GetContentRandomlyService;
use App\UseCases\Interfaces\GetRamdomlyFromApiUseCase;
use App\Repositories\GooglePlaceIds\GooglePlaceIdRepository;
use App\UseCases\RequestCountHistorys\RequestCountHistoryStoreUseCase;
use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;
use App\Services\RequestApis\NearBySearches\NearBySearchRequestApiService;

class NearBySearchGetUseCase implements GetRamdomlyFromApiUseCase
{
    private $body;
    private $generateLocationService;
    private $nearBySearchRequestApiService;
    private $getContentRandomlyService;
    private $googlePlaceIdRepository;

    public function __construct(
        object $request,
        GenerateLocationService $generateLocationService,
        NearBySearchRequestApiService $nearBySearchRequestApiService,
        GetContentRandomlyService $getContentRandomlyService,
        GooglePlaceIdRepository $googlePlaceIdRepository
    ) {
        $this->request = $request;
        $this->generateLocationService = $generateLocationService;
        $this->nearBySearchRequestApiService = $nearBySearchRequestApiService;
        $this->getContentRandomlyService = $getContentRandomlyService;
        $this->googlePlaceIdRepository = $googlePlaceIdRepository;
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

        // Get content randomly
        $this->getContentRandomlyService->handle($this->nearBySearchRequestApiService->response_body);

        $this->_formatResponse();

        // Store request count history
        $this->requestCountHistoryStoreUseCase->handle($user_id, $type_id);

        // Store google place id
        $this->googlePlaceIdRepository->store($this->body);

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
        $value = $this->getContentRandomlyService->content;
        $this->body = [
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

    /**
     * Return data
     *
     * @return array
     */
    private function _return(): array
    {
        return $this->body;
    }
}
