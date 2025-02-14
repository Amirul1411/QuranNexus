<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surah;

class SurahController extends Controller
{
    public function index()
    {
        $surahs = Surah::all();

        return view('surah-list', [
            'surahs' => $surahs,
        ]);
    }

    public function show(Surah $surah)
    {
        return view('recitation', [
            'surah' => $surah,
        ]);
    }
}
