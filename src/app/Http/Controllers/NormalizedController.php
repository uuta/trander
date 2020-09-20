<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Normalize request and response parameters
 *
 * @author Yuta Aoki
 */
class NormalizedController extends Controller
{
    /**
     * Change request parameter from camel case to snake case
     *
     * @param object $request
     * @return object
     */
    protected function normarize_request(Object $request) : object
    {
        foreach ($request->all() as $key => $value) {
            if(preg_match('/[A-Z]/', $key)){
                $new_key = Str::snake($key);
                $request->merge([$new_key => $request->$key]);
                $request->offsetUnset($key);
            }
        }
        return $request;
    }

    /**
     * Change response parameter from snake case to camel case
     *
     * @param ?array $response
     * @return ?array
     */
    protected function normarize_response(?array $response) {
        if(isset($response)) {
            foreach ($response as $key => $value) {
                if(preg_match('/[_]/', $key)){
                    $new_key = Str::camel($key);
                    $response[$new_key] = $value;
                    unset($response[$key]);
                }
            }
        }
        return $response;
    }

    /**
     * Change multiple response parameter from snake case to camel case
     *
     * @param ?array $response
     * @return ?array
     */
    protected function normarize_multiple_response(?array $response) {
        if(isset($response)) {
            foreach ($response as $i => $v) {
                foreach ($v as $key => $value) {
                    if(preg_match('/[_]/', $key)){
                        $new_key = Str::camel($key);
                        $response[$i][$new_key] = $value;
                        unset($response[$i][$key]);
                    }
                }
            }
        }
        return $response;
    }
}
