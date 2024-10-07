<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Juz;

class JuzController extends Controller
{
    public function index()
    {
        $alljuzs = Juz::all();

        return $alljuzs;
    }

    public function show(Juz $juz)
    {
        return view('recitation', [
            'juz' => $juz,
        ]);
    }
}
