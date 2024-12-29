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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function(){
    Route::apiResource('surahs', APISurahController::class)->name('index','api_surah.index')->name('show', 'api_surah.show');
    Route::apiResource('ayahs', APIAyahController::class)->name('index','api_ayah.index')->name('show', 'api_ayah.show');
    Route::apiResource('pages', APIPageController::class)->name('index','api_page.index')->name('show', 'api_page.show');
    Route::apiResource('words', APIWordController::class)->name('index','api_word.index')->name('show', 'api_word.show');
    Route::apiResource('juzs', APIJuzController::class)->name('index','api_juz.index')->name('show', 'api_juz.show');
    Route::apiResource('translations', APITranslationController::class)->name('index','api_translation.index')->name('show', 'api_translation.show');
    Route::apiResource('surah_info', APISurahInfoController::class)->name('index','api_surah_info.index')->name('show', 'api_surah_info.show');
    Route::apiResource('tafseer', APITafseerController::class)->name('index','api_tafseer.index')->name('show', 'api_tafseer.show');
    Route::apiResource('audio_recitations', APIAudioRecitationController::class)->name('index','api_audio_recitation.index')->name('show', 'api_audio_recitation.show');
    Route::apiResource('audio_recitation_info', APIAudioRecitationInfoController::class)->name('index','api_audio_recitation_info.index')->name('show', 'api_audio_recitation_info.show');
    Route::apiResource('tafseer_info', APITafseerInfoController::class)->name('index','api_tafseer_info.index')->name('show', 'api_tafseer_info.show');
    Route::apiResource('translation_info', APITranslationInfoController::class)->name('index','api_translation_info.index')->name('show', 'api_translation_info.show');
    Route::apiResource('achievements', APIAchievementController::class)->name('index','api_achievement.index')->name('show', 'api_achievement.show');
});
