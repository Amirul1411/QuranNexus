<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\APISurahController;

class AyahController extends Controller
{
    // public function show($surahId)
    // {

    //     // If you want to use an internal API call to fetch Surah data
    //     $apiController = new APISurahController();
    //     $surah = $apiController->show($surahId)->getData();

    //     // Or fetch directly from the database if appropriate
    //     // $surah = Surah::find($surahId);

    //     if (!$surah) {
    //         abort(404, 'Surah not found');
    //     }

    //     // Pass data to the view
    //     return view('recitation', [
    //         'surah' => $surah,
    //         // 'ayahs' => $surah->ayahs, // Assuming you've set up relationships
    //     ]);
    // }
}
