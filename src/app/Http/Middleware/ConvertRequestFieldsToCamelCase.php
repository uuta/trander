<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Closure;
use Illuminate\Support\Facades\Log;

class ConvertRequestFieldsToCamelCase
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
        $replaced = [];
        foreach ($request->all() as $key => $value) {
            $replaced[Str::snake($key)] = $value;
        }
        $request->replace($replaced);

        return $next($request);
    }
}
