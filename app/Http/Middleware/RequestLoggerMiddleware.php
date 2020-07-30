<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class RequestLoggerMiddleware
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
        Log::info("====== Request URL ======");
        Log::info($request->fullUrl());
        Log::info("====== Request Params ======");
        Log::info($request->all());
        Log::info("====== Response ======");
        Log::info($response);
        return $response;
    }
}
