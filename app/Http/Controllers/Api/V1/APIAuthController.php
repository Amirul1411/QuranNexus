<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class APIAuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Password::defaults()],
                'device_name' => ['required', 'string'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'USER',
                'settings' => [
                    'translation_id' => null,
                    'tafseer_id' => null,
                    'audio_id' => null,
                ],
            ]);

            // Manually create token
            $plainTextToken = Str::random(40);
            
            $token = new PersonalAccessToken();
            $token->tokenable_type = User::class;
            $token->tokenable_id = $user->_id;
            $token->name = $request->device_name;
            $token->token = hash('sha256', $plainTextToken);
            $token->abilities = ['*'];
            $token->save();

            return response()->json([
                'message' => 'Registration successful',
                'token' => $token->_id . '|' . $plainTextToken,
                'user' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ], 201);

        } catch (ValidationException $e) {
            Log::error('Registration validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Registration failed', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            // Delete any existing tokens for this device
            PersonalAccessToken::where('tokenable_id', $user->_id)
                ->where('name', $request->device_name)
                ->delete();

            // Create new token
            $plainTextToken = Str::random(40);
            
            $token = new PersonalAccessToken();
            $token->tokenable_type = User::class;
            $token->tokenable_id = $user->_id;
            $token->name = $request->device_name;
            $token->token = hash('sha256', $plainTextToken);
            $token->abilities = ['*'];
            $token->save();

            return response()->json([
                'token' => $token->_id . '|' . $plainTextToken,
                'user' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]);

        } catch (ValidationException $e) {
            Log::error('Login validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Login failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function profile(Request $request)
    {
        try {
            // Debug logging for token
            $bearerToken = $request->bearerToken();
            \Log::debug('Token debug', [
                'has_bearer_token' => !empty($bearerToken),
                'token' => $bearerToken
            ]);
    
            if ($bearerToken) {
                // Split and check token parts
                $parts = explode('|', $bearerToken);
                \Log::debug('Token parts', [
                    'parts_count' => count($parts),
                    'token_id' => $parts[0] ?? null
                ]);
    
                if (count($parts) === 2) {
                    $tokenId = $parts[0];
                    // Check if token exists in DB
                    $token = PersonalAccessToken::find($tokenId);
                    \Log::debug('Token lookup', [
                        'token_found' => !is_null($token),
                        'token_details' => $token ? [
                            'id' => $token->_id,
                            'tokenable_id' => $token->tokenable_id,
                            'name' => $token->name
                        ] : null
                    ]);
                }
            }
    
            $user = $request->user();
            \Log::debug('User check', [
                'has_user' => !is_null($user),
                'user_details' => $user ? [
                    'id' => $user->_id,
                    'email' => $user->email
                ] : null
            ]);
    
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated',
                    'debug_info' => [
                        'has_token' => !empty($bearerToken),
                        'token_format_valid' => !empty($bearerToken) && str_contains($bearerToken, '|')
                    ]
                ], 401);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'settings' => $user->settings ?? []
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Profile error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching profile',
                'debug_info' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if ($token = $request->bearerToken()) {
                [$id, $token] = explode('|', $token, 2);
                PersonalAccessToken::where('_id', $id)->delete();
            }
            
            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Logout failed', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}