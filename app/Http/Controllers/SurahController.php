<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import the HTTP client

class SurahController extends Controller
{
    public function __invoke(Request $request)
    {
        // Make an HTTP GET request to the API endpoint
        $response = Http::get('http://127.0.0.1:8000/api/v1/surahs');

        // Decode the JSON response
        $surahs = $response->json();

        dd($surahs);

        return view('surah-list');
    }
}
