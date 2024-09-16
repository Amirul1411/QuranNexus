<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\APISurahController;
use App\Models\Surah;

class SurahController extends Controller
{
    public function index()
    {
        $apiController = new APISurahController();
        $surahs = $apiController->index();

        return view('surah-list', [
            'surahs' => $surahs,
        ]);
    }

    public function show(Surah $surah)
    {

        // If you want to use an internal API call to fetch Surah data
        $apiController = new APISurahController();
        $surahResource = $apiController->show($surah);

        // $surah = $apiController->show($surahId)->getData();

        // Or fetch directly from the database if appropriate
        // $surah = Surah::find($surahId);

        if (!$surahResource) {
            abort(404, 'Surah not found');
        }

        $surahModel = $surahResource->resource;

        // Pass data to the view
        return view('recitation', [
            'surah' => $surahModel,
        ]);
    }
}
