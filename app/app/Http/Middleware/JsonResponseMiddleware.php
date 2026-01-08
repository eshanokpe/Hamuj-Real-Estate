<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Force JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            $request->headers->set('Accept', 'application/json');
        }
        
        $response = $next($request);
        
        // Ensure JSON response
        if ($request->ajax() || $request->wantsJson()) {
            $response->headers->set('Content-Type', 'application/json');
        }
        
        return $response;
    }
}