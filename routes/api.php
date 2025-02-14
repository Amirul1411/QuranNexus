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
use App\Http\Controllers\Api\V1\APIUserAchievementController;

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\LoggingAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::prefix('mobile')->group(function () {
    // Public routes
    Route::post('/register', [APIAuthController::class, 'register']);
    Route::post('/login', [APIAuthController::class, 'login']);
    Route::post('/forgot-password', [APIAuthController::class, 'forgotPassword']);

    Route::get('words/search', [APIWordController::class, 'search']);
    Route::get('words/distribution', [APIWordController::class, 'getWordJuzDistribution']);
    Route::get('words/chapters-distribution', [APIWordController::class, 'getWordsChaptersDistribution']);



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



    // Authenticated routes
    Route::middleware(['auth.logging'])->group(function () {
        Route::get('/profile', [APIAuthController::class, 'profile']);
        // Quiz routes
        Route::post('/quiz/start', [QuizProgressController::class, 'startQuiz']);
        Route::post('/quiz/answer', [QuizProgressController::class, 'submitAnswer']);
        Route::post('/quiz/submit-batch', [QuizProgressController::class, 'submitBatchAnswers']);
        Route::get('/quiz/progress', [QuizProgressController::class, 'getQuizProgress']);
        Route::post('/quiz/finish', [QuizProgressController::class, 'finishQuiz']);

        Route::post('/achievements/unlock', [APIUserAchievementController::class, 'unlockAchievement']);
        Route::get('/achievements/status', [APIUserAchievementController::class, 'getAchievementStatus']);
        Route::get('/achievements/check-streak', [APIUserAchievementController::class, 'checkStreakAchievement']);
        
        Route::get('/bookmarks', [APIBookmarkController::class, 'getBookmarks']);
        Route::post('/bookmarks', [APIBookmarkController::class, 'addBookmark']);
        Route::delete('/bookmarks/{type}/{itemId}', [APIBookmarkController::class, 'removeBookmark']);
        
        Route::post('/bookmarks/migrate', [APIBookmarkController::class, 'migrateBookmarks']);
      
        });
    });
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

