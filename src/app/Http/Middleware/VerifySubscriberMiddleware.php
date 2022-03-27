<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Repositories\RequestLimits\RequestLimitRepository;
use App\Services\RequestApis\Subscribers\SubscriberRequestApiService;

class VerifySubscriberMiddleware
{
    private $response;
    private $result;

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
                'errors' => $this->_returnDiff(),
            ], 402);
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
        $this->response = (new SubscriberRequestApiService())->request($request->get('auth0_sub'));
    }

    /**
     * Check subscription is expired
     *
     * @return void
     */
    private function _isSubscriptionExpired(): bool
    {
        // TEST:
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
        $this->result = (new RequestLimitRepository())->findById($request->get('auth0_sub'));

        // Empty
        if ($this->result->isEmpty()) {
            return false;
        }

        return ($this->result[0]->request_limit <= 0);
    }

    /**
     * Return diff
     *
     * @return array
     */
    private function _returnDiff(): string
    {
        $now = new Carbon();
        $first_request_at = new Carbon($this->result[0]->first_request_at);
        $value = $now->diffInSeconds($first_request_at);
        return CarbonInterval::seconds($value)->cascade()->forHumans();
    }
}
