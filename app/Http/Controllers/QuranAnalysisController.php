<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuranAnalysisController extends Controller
{
    public function show()
    {
        return view('quran-analysis');
    }
}
