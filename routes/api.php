<?php

use App\Http\Controllers\Api\V1\APIAchievementController;
use App\Http\Controllers\Api\V1\APIAyahController;
use App\Http\Controllers\Api\V1\APIPageController;
use App\Http\Controllers\Api\V1\APISurahController;
use App\Http\Controllers\Api\V1\APIWordController;
use App\Http\Controllers\Api\V1\APIJuzController;
use App\Http\Controllers\Api\V1\APISurahInfoController;
use App\Http\Controllers\Api\V1\APITafseerController;
use App\Http\Controllers\Api\V1\APITranslationController;
use App\Http\Controllers\Api\V1\APIAudioRecitationController;
use App\Http\Controllers\Api\V1\APIAudioRecitationInfoController;
use App\Http\Controllers\Api\V1\APITafseerInfoController;
use App\Http\Controllers\Api\V1\APITranslationInfoController;
use App\Http\Controllers\Api\V1\APIAuthController;
use App\Http\Controllers\Api\V1\APIBookmarkController;
use App\Http\Controllers\Api\V1\QuizProgressController;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\LoggingAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/register', [APIAuthController::class, 'register']);
    Route::post('/login', [APIAuthController::class, 'login']);
    Route::get('/debug-auth-state', function (Request $request) {
        return response()->json([
            'is_authenticated' => auth()->check(),
            'auth_guard' => auth()->getDefaultDriver(),
            'user' => auth()->user(),
            'token_present' => !empty($request->bearerToken()),
            'token' => $request->bearerToken(),
            'sanctum_guard' => auth()->guard('sanctum')->check(),
            'sanctum_user' => auth()->guard('sanctum')->user(),
            'guards' => array_keys(config('auth.guards')),
            'default_guard' => config('auth.defaults.guard')
        ]);
    });
    Route::get('/debug-token-full', function (Request $request) {
        try {
            $token = $request->bearerToken();
            if (!$token) {
                return response()->json(['error' => 'No token provided']);
            }
    
            [$id, $plainTextToken] = explode('|', $token, 2);
            
            // Get token record
            $tokenRecord = \App\Models\PersonalAccessToken::find($id);
            if (!$tokenRecord) {
                return response()->json(['error' => 'Token not found in database']);
            }
    
            // Get user
            $user = \App\Models\User::find($tokenRecord->tokenable_id);
            
            return response()->json([
                'token_info' => [
                    'id' => (string)$tokenRecord->_id,
                    'tokenable_type' => $tokenRecord->tokenable_type,
                    'tokenable_id' => $tokenRecord->tokenable_id,
                    'hash_matches' => hash_equals($tokenRecord->token, hash('sha256', $plainTextToken))
                ],
                'user_info' => $user ? [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email
                ] : null,
                'relations' => [
                    'id_match' => $user ? ($tokenRecord->tokenable_id === (string)$user->_id) : false
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Debug error',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    });
    // Protected routes
    // Route::middleware(['auth:sanctum', 'auth.logging'])->group(function () {
    //     Route::get('/test', function () {
    //         return response()->json([
    //             'message' => 'Authenticated successfully',
    //             'user' => auth()->user()
    //         ]);
    //     });

    //     Route::middleware('auth:sanctum')->group(function () {
    //         Route::get('/profile', [APIAuthController::class, 'profile']);
    //         Route::post('/logout', [APIAuthController::class, 'logout']);

    //     });
    //     // Quiz routes
    //     Route::post('/quiz/start', [QuizProgressController::class, 'startQuiz']);
    //     Route::post('/quiz/answer', [QuizProgressController::class, 'submitAnswer']);
    //     Route::get('/quiz/progress', [QuizProgressController::class, 'getQuizProgress']);
    //     Route::post('/quiz/finish', [QuizProgressController::class, 'finishQuiz']);
    // });

    Route::middleware(['auth.logging'])->group(function () {
        Route::get('/profile', [APIAuthController::class, 'profile']);
        // ... other authenticated routes
    });
});



Route::prefix('mobile')->group(function () {
    Route::get('/bookmarks/{userId}', [APIBookmarkController::class, 'getBookmarks']);
    Route::post('/users/{userId}/bookmarks', [APIBookmarkController::class, 'addBookmark']);
    Route::delete('/users/{userId}/bookmarks/{bookmarkId}', [APIBookmarkController::class, 'removeBookmark']);
});


Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function(){
    Route::apiResource('surahs', APISurahController::class)->name('index','surah.index')->name('show', 'surah.show');
    Route::apiResource('ayahs', APIAyahController::class)->name('index','ayah.index')->name('show', 'ayah.show');
    Route::apiResource('pages', APIPageController::class)->name('index','page.index')->name('show', 'page.show');
    Route::apiResource('words', APIWordController::class)->name('index','word.index')->name('show', 'word.show');
    Route::apiResource('juzs', APIJuzController::class)->name('index','juz.index')->name('show', 'juz.show');
    Route::apiResource('translations', APITranslationController::class)->name('index','translation.index')->name('show', 'translation.show');
    Route::apiResource('surah_info', APISurahInfoController::class)->name('index','surah_info.index')->name('show', 'surah_info.show');
    Route::apiResource('tafseer', APITafseerController::class)->name('index','tafseer.index')->name('show', 'tafseer.show');
    Route::apiResource('audio_recitations', APIAudioRecitationController::class)->name('index','audio_recitation.index')->name('show', 'audio_recitation.show');
    Route::apiResource('audio_recitation_info', APIAudioRecitationInfoController::class)->name('index','audio_recitation_info.index')->name('show', 'audio_recitation_info.show');
    Route::apiResource('tafseer_info', APITafseerInfoController::class)->name('index','tafseer_info.index')->name('show', 'tafseer_info.show');
    Route::apiResource('translation_info', APITranslationInfoController::class)->name('index','translation_info.index')->name('show', 'translation_info.show');
    Route::apiResource('achievements', APIAchievementController::class)->name('index','achievement.index')->name('show', 'achievement.show');

    // Temporary route
    Route::get('chapters/{id}/verses', [APIAyahController::class, 'getVersesByChapter']);
});


Route::get('/debug-auth', function (Request $request) {
    try {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'error' => 'No bearer token provided',
                'authorization_header' => $request->header('Authorization')
            ]);
        }

        Log::info('Debug route token', [
            'full_token' => $token,
        ]);

        [$id, $plainTextToken] = explode('|', $token, 2);
        
        // Try direct model find first
        $tokenRecord = \App\Models\PersonalAccessToken::find($id);
        
        if (!$tokenRecord) {
            // If not found, try with MongoDB's ObjectID
            try {
                $objectId = new \MongoDB\BSON\ObjectId($id);
                $tokenRecord = \App\Models\PersonalAccessToken::raw(function($collection) use ($objectId) {
                    return $collection->findOne(['_id' => $objectId]);
                });
            } catch (\Exception $e) {
                Log::error('MongoDB query error', [
                    'error' => $e->getMessage(),
                    'id' => $id
                ]);
            }
        }

        if (!$tokenRecord) {
            return response()->json([
                'error' => 'Token record not found',
                'searched_id' => $id,
                'search_attempts' => [
                    'direct_find' => false,
                    'objectid_find' => false
                ]
            ]);
        }

        // Convert to array if it's a MongoDB document
        $tokenData = is_array($tokenRecord) ? $tokenRecord : $tokenRecord->toArray();
        
        $hashedReceived = hash('sha256', $plainTextToken);
        
        return response()->json([
            'token_record_exists' => true,
            'token_data' => [
                'id' => $id,
                'hash_matches' => hash_equals($tokenData['token'], $hashedReceived),
                'stored_hash' => $tokenData['token'],
                'received_hash' => $hashedReceived,
                'tokenable_type' => $tokenData['tokenable_type'],
                'tokenable_id' => $tokenData['tokenable_id']
            ]
        ]);
    } catch (\Exception $e) {
        Log::error('Debug route error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'error' => 'Debug route error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
});

