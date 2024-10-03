<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FAQsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\JuzController;
use App\Http\Controllers\SurahInfoController;
use App\Http\Controllers\TafseerController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/Home');

Route::get('/Home', [HomeController::class, 'index'])->name('home');

Route::get('/Contact', [ContactController::class, 'index'])->name('contact');

Route::get('/FAQs', [FAQsController::class, 'index'])->name('faqs');

Route::get('/Surah', [SurahController::class, 'index'])->name('surah.index');

Route::get('/Surah/{surah}', [SurahController::class, 'show'])->name('surah.show');

Route::get('/SurahInfo/{surah_info}', [SurahInfoController::class, 'show'])->name('surah_info.show');

Route::get('/Page/{page}', [PageController::class, 'show'])->name('page.show');

Route::get('/Juz/{juz}', [JuzController::class, 'show'])->name('juz.show');

Route::get('/Tafseer/{tafseer}', [TafseerController::class, 'show'])->name('tafseer.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
