<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        
        $response = $next($request);
        
        // If response is not JSON and not a successful response, convert to JSON
        if (!$response->headers->has('Content-Type') || 
            !str_contains($response->headers->get('Content-Type'), 'application/json')) {
            $content = $response->getContent();
            return response()->json([
                'status' => 'error',
                'message' => $content
            ], $response->getStatusCode());
        }
        
        return $response;
    }
}