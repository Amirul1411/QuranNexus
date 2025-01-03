<?php

use App\Http\Controllers\APIDocumentationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FAQsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\JuzController;
use App\Http\Controllers\QuranAnalysisController;
use App\Http\Controllers\SurahInfoController;
use App\Http\Controllers\TafseerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewPageController;
use App\Http\Controllers\NewSurahController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AyahController;
use App\Http\Controllers\WordController;

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

Route::get('/QuranAnalysis', [QuranAnalysisController::class, 'show'])->name('quran_analysis.show');

Route::get('/APIDocumentation', [APIDocumentationController::class, 'index'])->name('api_documentation.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/new-page', [NewPageController::class, 'index']);
Route::get('/surah/{id}', [NewSurahController::class, 'show']);
Route::get('/surahs', [NewSurahController::class, 'index']);

Route::get('/basic-search', [SearchController::class, 'basicSearch'])->name('basic-search');
Route::post('/search', [SearchController::class, 'search'])->name('search.perform');
Route::get('/advanced-search', [SearchController::class, 'advancedSearch'])->name('advanced-search');

Route::get('/ayah/{ayahKey?}', [AyahController::class, 'index'])->name('ayah.index');
Route::post('/ayah/{ayahKey}/verify', [AyahController::class, 'verify'])->name('ayah.verify');
Route::get('/ayah/{ayahKey}/next', [AyahController::class, 'next'])->name('ayah.next');
Route::get('/ayah/{ayahKey}/back', [AyahController::class, 'back'])->name('ayah.back');

Route::get('/word/{wordKey?}', [WordController::class, 'index'])->name('word.index');
Route::post('/word/{wordKey}/verify', [WordController::class, 'verify'])->name('word.verify');
Route::get('/word/{wordKey}/next', [WordController::class, 'next'])->name('word.next');
Route::get('/word/{wordKey}/back', [WordController::class, 'back'])->name('word.back');
