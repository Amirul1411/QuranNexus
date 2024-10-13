<?php

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
    Route::apiResource('surahs', APISurahController::class);
    Route::apiResource('ayahs', APIAyahController::class);
    Route::apiResource('pages', APIPageController::class);
    Route::apiResource('words', APIWordController::class);
    Route::apiResource('juzs', APIJuzController::class);
    Route::apiResource('translations', APITranslationController::class);
    Route::apiResource('surah_info', APISurahInfoController::class);
    Route::apiResource('tafseer', APITafseerController::class);
    Route::apiResource('audio_recitations', APIAudioRecitationController::class);
    Route::apiResource('audio_recitation_info', APIAudioRecitationInfoController::class);
    Route::apiResource('tafseer_info', APITafseerInfoController::class);
    Route::apiResource('translation_info', APITranslationInfoController::class);
});
