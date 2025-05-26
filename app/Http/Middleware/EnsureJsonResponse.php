<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Http\Response as IlluminateResponse;

class EnsureJsonResponse
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        // Force JSON responses for API requests
        $request->headers->set('Accept', 'application/json');

        // Handle the request
        $response = $next($request);

        // Add CORS headers to all responses
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-XSRF-Token');
        $response->headers->set('Access-Control-Max-Age', '86400');

        // Handle OPTIONS requests explicitly
        if ($request->getMethod() === 'OPTIONS') {
            return response()->json([], 204)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-XSRF-Token');
        }

        return $response;
    }
}