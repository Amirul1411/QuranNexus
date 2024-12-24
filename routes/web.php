<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewPageController;
use App\Http\Controllers\SurahController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/new-page', [NewPageController::class, 'index']);
Route::get('/surah/{id}', [SurahController::class, 'show']);
Route::get('/surahs', [SurahController::class, 'index']);

use App\Http\Controllers\SearchController;

Route::get('/basic-search', [SearchController::class, 'basicSearch'])->name('basic-search');
Route::post('/search', [SearchController::class, 'search'])->name('search.perform');
Route::get('/advanced-search', [SearchController::class, 'advancedSearch'])->name('advanced-search');

use App\Http\Controllers\AyahController;

Route::get('/ayah/{ayahKey?}', [AyahController::class, 'index'])->name('ayah.index');
Route::post('/ayah/{ayahKey}/verify', [AyahController::class, 'verify'])->name('ayah.verify');
Route::get('/ayah/{ayahKey}/next', [AyahController::class, 'next'])->name('ayah.next');
Route::get('/ayah/{ayahKey}/back', [AyahController::class, 'back'])->name('ayah.back');