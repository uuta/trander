<?php

namespace App\Services\RequestApis\Subscribers;

use App\Consts\ApiConst;
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
        $query = [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . config('const.revenue_cat.api_key'),
            ],
        ];
        return (new ApiService(
            'GET',
            ApiConst::SUBSCRIBER . $auth0_sub,
            $query
        ))->request();
    }
}
