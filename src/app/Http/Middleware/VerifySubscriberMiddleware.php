<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Http\Models\RequestLimit;
use App\Services\Dates\DiffDateService;
use App\Repositories\RequestLimits\RequestLimitRepository;

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
                'message' => (new DiffDateService(
                    (new Carbon(RequestLimit::RESTORE_DATE)),
                    new Carbon($this->result[0]->first_request_at)
                ))->getDiffAll(),
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
        $this->response = (resolve('SubscriberRequestApiService'))->request($request->get('auth0_sub'));
    }

    /**
     * Check subscription is expired
     *
     * @return void
     */
    private function _isSubscriptionExpired(): bool
    {
        $body = json_decode($this->response->getBody(), true);

        if (!array_key_exists('subscription', $body['subscriber']['subscriptions'])) {
            return true;
        }

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
}
