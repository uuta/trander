<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\RequestLimits\ConsumeRequestLimitRepository;

class ConsumeRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // TODO: Not cool, should improve
        // Only test
        if (app()->runningUnitTests()) {
            (new ConsumeRequestLimitRepository())->store($request->get('auth0_sub'));
            return $response;
        }

        // Only consume the request limit if the request was successful.
        if ($response->status() === 200) {
            (new ConsumeRequestLimitRepository())->store($request->get('auth0_sub'));
        }

        return $response;
    }
}
