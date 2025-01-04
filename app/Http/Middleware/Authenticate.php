<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;
use Illuminate\Support\Facades\Log;
class Authenticate extends BaseAuthenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            // Log the auth header for debugging
            Log::info('Auth attempt', [
                'header' => $request->header('Authorization'),
                'token' => $request->bearerToken()
            ]);

            if (!$request->header('Authorization')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No authorization header found'
                ], 401);
            }

            if (!str_starts_with($request->header('Authorization'), 'Bearer ')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid authorization header format. Must start with "Bearer "'
                ], 401);
            }

            $this->authenticate($request, $guards);
            return $next($request);
        } catch (\Exception $e) {
            Log::error('Authentication failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticatedd',
                'details' => $e->getMessage()
            ], 401);
        }
    }
}
