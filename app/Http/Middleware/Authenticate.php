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
            Log::info('Auth attempt', [
                'header' => $request->header('Authorization'),
                'token' => $request->bearerToken(),
                'guards' => $guards
            ]);

            $this->authenticate($request, $guards);
            
            Log::info('User authenticated', [
                'user' => auth()->user() ? auth()->user()->_id : null
            ]);

            return $next($request);
        } catch (\Exception $e) {
            Log::error('Authentication failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated',
                'details' => $e->getMessage()
            ], 401);
        }
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }
}