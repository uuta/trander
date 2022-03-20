<?php

namespace App\Services\RequestApis\Subscribers;

use Psr\Http\Message\ResponseInterface;
use App\Services\RequestApis\ApiService;

class SubscriberRequestApiService
{
    /**
     * Request to API
     *
     * @param ?string $auth0_sub
     * @return ResponseInterface
     */
    public function request(?string $auth0_sub): ResponseInterface
    {
        return (new ApiService(
            'GET',
            "https://api.revenuecat.com/v1/subscribers/{$auth0_sub}",
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . config('const.revenue_cat.api_key'),
                ],
            ]
        ))->request();
    }
}
