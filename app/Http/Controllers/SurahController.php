<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surah;

class SurahController extends Controller
{
    public function show($id)
    {
        $surah = Surah::with('info')->where('_id', '=', $id)->first();

        if (!$surah) {
            return response()->json(["error" => "Surah not found"], 404);
        }

        return view('surah', ['surah' => $surah]);
    }

    public function index()
    {
        $surahs = Surah::with('info')->get();

        return view('surahs', ['surahs' => $surahs]);
    }
}