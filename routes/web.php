<?php

use App\Http\Controllers\AyahController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurahController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/Home');

Route::get('/Home', [HomeController::class, 'index'])->name('home');

Route::get('/Contact', [ContactController::class, 'index'])->name('contact');

Route::get('/Surah', [SurahController::class, 'index'])->name('surah.index');

Route::get('/Surah/{surah}', [SurahController::class, 'show'])->name('surah.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
