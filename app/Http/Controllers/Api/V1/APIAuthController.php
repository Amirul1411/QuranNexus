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
                'role' => User::ROLE_DEFAULT,
                'settings' => [
                    'translation_id' => null,
                    'tafseer_id' => null,
                    'audio_id' => null,
                ],
                'recitation_times' => [],
                'recitation_streak' => 0,
                'last_recitation_date' => null,
                'recitation_goal' => null,
            ]);

            // Create token manually for MongoDB
            $token = new PersonalAccessToken();
            $token->tokenable_type = User::class;
            $token->tokenable_id = $user->_id;
            $token->name = $request->device_name;
            $plainTextToken = Str::random(40);
            $token->token = hash('sha256', $plainTextToken);
            $token->abilities = ['*'];
            $token->save();

            return response()->json([
                'message' => 'Registration successful',
                'token' => $token->id . '|' . $plainTextToken,
                'user' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration',
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

            // Delete existing tokens for this device name (optional)
            PersonalAccessToken::where('tokenable_id', $user->_id)
                ->where('name', $request->device_name)
                ->delete();

            // Create new token manually for MongoDB
            $token = new PersonalAccessToken();
            $token->tokenable_type = User::class;
            $token->tokenable_id = $user->_id;
            $token->name = $request->device_name;
            $plainTextToken = Str::random(40);
            $token->token = hash('sha256', $plainTextToken);
            $token->abilities = ['*'];
            $token->save();

            return response()->json([
                'token' => $token->id . '|' . $plainTextToken,
                'user' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Delete the current token
            $tokenId = explode('|', $request->bearerToken())[0] ?? null;
            if ($tokenId) {
                PersonalAccessToken::where('_id', $tokenId)->delete();
            }
            
            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'settings' => $user->settings,
                    'recitation_times' => $user->recitation_times,
                    'recitation_streak' => $user->recitation_streak,
                    'last_recitation_date' => $user->last_recitation_date,
                    'recitation_goal' => $user->recitation_goal,
                    'profile_photo_url' => $user->profile_photo_url,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
