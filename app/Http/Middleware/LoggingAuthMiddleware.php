<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PersonalAccessToken;
use App\Models\User;

class LoggingAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $publicRoutes = [
                'api/v1/login',
                'api/v1/register',
                'api/debug-token-full'
            ];

            if (in_array($request->path(), $publicRoutes)) {
                return $next($request);
            }

            $bearerToken = $request->bearerToken();
            Log::info('Auth middleware processing', [
                'path' => $request->path(),
                'has_token' => !empty($bearerToken)
            ]);

            if (!$bearerToken) {
                return response()->json(['message' => 'No token provided'], 401);
            }

            // Parse and verify token
            [$tokenId, $plainTextToken] = explode('|', $bearerToken, 2);
            
            Log::info('Token parts', [
                'id' => $tokenId,
                'token_length' => strlen($plainTextToken)
            ]);

            $accessToken = PersonalAccessToken::find($tokenId);
            
            if (!$accessToken) {
                Log::error('Token not found', ['id' => $tokenId]);
                return response()->json(['message' => 'Invalid token'], 401);
            }

            // Verify hash
            if (!hash_equals($accessToken->token, hash('sha256', $plainTextToken))) {
                Log::error('Token hash mismatch');
                return response()->json(['message' => 'Invalid token'], 401);
            }

            // Find and set user
            $user = User::findById($accessToken->tokenable_id);
            
            if (!$user) {
                Log::error('User not found', ['id' => $accessToken->tokenable_id]);
                return response()->json(['message' => 'User not found'], 401);
            }

            Log::info('User authenticated', [
                'user_id' => $user->_id,
                'email' => $user->email
            ]);

            // Set the user for both default and sanctum guards
            auth()->setUser($user);
            $user->withAccessToken($accessToken);
            
            return $next($request);
        } catch (\Exception $e) {
            Log::error('Auth middleware error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Authentication error',
                'error' => $e->getMessage()
            ], 401);
        }
    }
}