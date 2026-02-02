<?php

namespace App\Http\Middleware;

use Closure;

class CorsCleanup
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Remove CORS headers if they exist
        $response->headers->remove('Access-Control-Allow-Origin');
        $response->headers->remove('Access-Control-Allow-Methods');
        $response->headers->remove('Access-Control-Allow-Headers');
        $response->headers->remove('Access-Control-Allow-Credentials');

        return $response;
    }
}
