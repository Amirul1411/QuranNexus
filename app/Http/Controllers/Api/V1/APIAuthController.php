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
use Illuminate\Support\Facades\Mail; 
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
                'token' => (string)$token->_id . '|' . $plainTextToken,
                'user' => [
                    'id' => (string)$user->_id,
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

    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);
    
            $user = User::where('email', $request->email)->first();
    
            if ($user) {
                // Generate new password
                // $newPassword = Str::random(10);
                $newPassword = "password";
    
                // Update password
                $user->password = Hash::make($newPassword);
                $user->save();
    
                            // Print the new password to the terminal
          
                // Send simple email
                Mail::raw(
                    "Your temporary password for QuranNexus is: $newPassword\n\nPlease login and change your password as soon as possible.",
                    function($message) use ($user) {
                        $message->to($user->email)
                                ->subject('QuranNexus Password Reset');
                    }
                );
    
                return response()->json([
                    'message' => 'If that email exists in our system, we have sent password reset instructions.',
                    'new_password' => $newPassword // Include the new password in the response
                ]);
            }
    
            return response()->json([
                'message' => 'If that email exists in our system, we have sent password reset instructions.'
            ]);
    
        } catch (\Exception $e) {
            Log::error('Password reset failed', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Password reset failed'
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
            
            // Log before save
            Log::info('Before save:', [
                'token_model' => $token->toArray()
            ]);
            
            $saved = $token->save();
            
            // Log after save
            Log::info('After save:', [
                'save_result' => $saved,
                'token_id' => $token->_id,
                'token_attributes' => $token->getAttributes()
            ]);
    
            // Try different ways to get the token ID
            $mongoId = $token->getKey();
            $rawId = $token->getAttribute('_id');
            
            Log::info('ID checks:', [
                'mongo_id' => $mongoId,
                'raw_id' => $rawId,
                'direct_id' => $token->_id
            ]);
    
            // Get the latest token for this user/device
            $latestToken = PersonalAccessToken::where('tokenable_id', $user->_id)
                                            ->where('name', $request->device_name)
                                            ->orderBy('created_at', 'desc')
                                            ->first();
            
            Log::info('Latest token:', [
                'found' => !is_null($latestToken),
                'token_details' => $latestToken ? $latestToken->toArray() : null
            ]);
    
            if (!$latestToken) {
                throw new \Exception('Token was not saved successfully');
            }
    
            $fullToken = $latestToken->_id . '|' . $plainTextToken;
    
            return response()->json([
                'token' => $fullToken,
                'user' => [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]);
    
        } catch (\Exception $e) {
            Log::error('Login failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }  
    
    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            // Format the quiz_progress data
            $quizProgress = $user->quiz_progress ?? [];
            foreach ($quizProgress as &$quiz) {
                // Ensure answers is always an array
                $quiz['answers'] = $quiz['answers'] ?? [];
                // Ensure start_time and end_time are strings
                $quiz['start_time'] = is_string($quiz['start_time']) ? $quiz['start_time'] : null;
                $quiz['end_time'] = is_string($quiz['end_time']) ? $quiz['end_time'] : null;
            }
    
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'settings' => $user->settings ?? [],
                    'recitationTimes' => $user->recitation_times ?? [],
                    'recitationStreak' => $user->recitation_streak ?? 0,
                    'lastRecitationDate' => $user->last_recitation_date,
                    'recitationGoal' => $user->recitation_goal,
                    'quiz_progress' => $quizProgress,
                    'created_at' => $user->created_at?->toDateTimeString(),
                    'updated_at' => $user->updated_at?->toDateTimeString()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Profile error', [
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