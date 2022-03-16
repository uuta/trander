<?php

namespace App\Http\Middleware;

use App\RequestLimit;
use Closure;
use App\Services\ApiService;

class VerifySubscriberMiddleware
{
    private $response;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->_request($request);
        if ($this->_isSubscriptionExpired() && $this->_isCountExpired($request)) {
            return response()->json([
                'errors' => ['Subscription is invalid.'],
            ], 401);
        }
        return $next($request);
    }

    /**
     * Request to API
     *
     * @param $request
     * @return void
     */
    private function _request($request): void
    {
        // TODO: Should cache
        $auth0_sub = $request->get('auth0_sub');
        $this->response = (new ApiService())->request(
            'GET',
            "https://api.revenuecat.com/v1/subscribers/{$auth0_sub}",
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . config('const.revenue_cat.api_key'),
                ],
            ]
        );
    }

    /**
     * Check subscription is expired
     *
     * @return void
     */
    private function _isSubscriptionExpired(): bool
    {
        $body = json_decode($this->response->getBody(), true);
        return ($body['subscriber']['subscriptions']['subscription']['expires_date'] < $body['request_date']);
    }

    /**
     * Check count is expired
     *
     * @param $request
     * @return boolean
     */
    private function _isCountExpired($request): bool
    {
        $result = RequestLimit::with(['user' => function ($query) use ($request) {
            $query->where('unique_id', $request->get('auth0_sub'));
        }])->get();

        // Empty
        if ($result->isEmpty()) {
            return false;
        }

        return ($result[0]->request_limit <= 0);
    }
}
