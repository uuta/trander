<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'auth0_email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::firstOrCreate(['email' => $request->auth0_email]);
        $request->merge([
            'userinfo' => $user
        ]);
        return $next($request);
    }
}
