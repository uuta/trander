<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Closure;
use Illuminate\Support\Facades\Log;

class ConvertResponseFieldsToCamelCase
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
        $content = $response->content();

        try {
            $json = json_decode($content, true);
            $replaced = [];

            if ($json === NULL) {
                return $response;
            }

            if ($response->headers->get('content-type') !== 'application/json') {
                return $response;
            }

            // Normalize validation messages
            if (array_key_exists('errors', $json)) {
                $replaced = $this->normalize_validation_messages($json);
            }
            else {
                $replaced = $this->normalize_response($json);
            }

            $response->setContent(json_encode($replaced, true));
        } catch (\Exception $e) {
            // you can log an error here if you want
            Log::error($e);
        }

        return $response;
    }

    /**
     * Normalize validation messages
     *
     * @param array $json
     * @return array
     */
    private function normalize_validation_messages(array $json) : array
    {
        foreach ($json as $i => $v) {
            foreach ($v as $key => $value) {
                if(preg_match('/[_]/', $key)){
                    $new_key = Str::camel($key);
                    $json[$i][$new_key] = $value;
                    unset($json[$i][$key]);
                }
            }
        }
        return $json;
    }

    /**
     * Change response parameter from snake case to camel case
     *
     * @param array $json
     * @return array
     */
    private function normalize_response(array $json) : array
    {
        foreach ($json as $key => $value) {
            if(preg_match('/[_]/', $key)){
                $new_key = Str::camel($key);
                $json[$new_key] = $value;
                unset($json[$key]);
            }
        }
        return $json;

    }
}