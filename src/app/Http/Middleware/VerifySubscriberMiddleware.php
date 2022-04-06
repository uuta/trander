<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Http\Models\RequestLimit;
use App\Services\Dates\DiffDateService;
use App\Repositories\RequestLimits\RequestLimitRepository;
use App\Services\Subscriptions\SubscriptionRequestVerificationService;

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
        $body = json_decode($this->response->getBody(), true);

        $request_limit = (new RequestLimitRepository())->findById(
            $request->get('auth0_sub')
        );

        $service = (new SubscriptionRequestVerificationService(
            $body,
            $request_limit
        ));

        if ($service->handle()) {
            return response()->json([
                'message' => (new DiffDateService(
                    (new Carbon(RequestLimit::RESTORE_DATE)),
                    new Carbon($request_limit[0]->first_request_at)
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
}
