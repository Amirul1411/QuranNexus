<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Surah;
use App\Models\SurahInfo;
use Illuminate\Http\Request;

class SurahInfoController extends Controller
{
    public function show(SurahInfo $surahInfo)
    {
        $surah = Surah::find($surahInfo->id);
        $surahInfo = SurahInfo::find($surahInfo->id);

        // Pass data to the view
        return view('surah-info', [
            'surah' => $surah,
            'surah_info' => $surahInfo,
        ]);
    }
}
