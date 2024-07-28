<?php

use App\Http\Controllers\AyahController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurahController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/Home');

Route::get('/Home', HomeController::class)->name('home');

Route::get('/SurahList', [SurahController::class, 'index'])->name('surah.index');

Route::get('/Recitation/{surah}', [SurahController::class, 'show'])->name('surah.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
