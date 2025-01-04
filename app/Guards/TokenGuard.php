<?php

namespace App\Guards;

use App\Models\PersonalAccessToken;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TokenGuard implements Guard
{
    use GuardHelpers;

    protected $request;
    protected $provider;

    public function __construct($provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function user()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $token = $this->request->bearerToken();
        Log::info('Token check', ['token' => $token]);

        if (!$token) {
            return null;
        }

        $accessToken = PersonalAccessToken::findToken($token);
        Log::info('Token found', ['token_exists' => (bool)$accessToken]);

        if (!$accessToken) {
            return null;
        }

        $this->user = $accessToken->tokenable;
        Log::info('User found', ['user_id' => $this->user?->_id]);

        return $this->user;
    }

    public function validate(array $credentials = [])
    {
        return false;
    }
}