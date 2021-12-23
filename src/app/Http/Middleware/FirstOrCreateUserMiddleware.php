<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class FirstOrCreateUserMiddleware
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
        $user = User::firstOrCreate(['email' => $request->auth0_email]);
        $request->merge([
            'userinfo' => $user
        ]);
        return $next($request);
    }
}
