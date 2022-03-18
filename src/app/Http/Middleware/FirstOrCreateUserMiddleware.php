<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Models\User;
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
            'auth0_sub' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::firstOrCreate(['unique_id' => $request->auth0_sub]);
        $request->merge([
            'userinfo' => $user
        ]);
        return $next($request);
    }
}
