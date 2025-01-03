<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surah;

class NewSurahController extends Controller
{
    public function show($id)
    {
        $surah = Surah::with('surahInfo')->where('_id', '=', $id)->first();

        if (!$surah) {
            return response()->json(["error" => "Surah not found"], 404);
        }

        return view('surah', ['surah' => $surah]);
    }

    public function index()
    {
        $surahs = Surah::with('surahInfo')->get();

        return view('surahs', ['surahs' => $surahs]);
    }
}
