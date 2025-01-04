<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Models\PersonalAccessToken;

class LoggingAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $publicRoutes = [
            'api/v1/login',
            'api/v1/register'
        ];

        if (in_array($request->path(), $publicRoutes)) {
            return $next($request);
        }

        Log::info('Auth attempt', [
            'path' => $request->path(),
            'header' => $request->header('Authorization'),
            'token' => $request->bearerToken()
        ]);

        if (!$request->bearerToken() || !auth()->guard('sanctum')->check()) {
            return response()->json([
                'message' => 'Invalid or expired token'
            ], 401);
        }

        return $next($request);
    }
}