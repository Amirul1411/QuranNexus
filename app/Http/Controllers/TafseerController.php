<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ayah;
use App\Models\Tafseer;
use Illuminate\Http\Request;

class TafseerController extends Controller
{
    public function show(Tafseer $tafseer)
    {
        $ayah = Ayah::find($tafseer->id);
        $tafseer = Tafseer::find($tafseer->id);

        // Pass data to the view
        return view('tafseer', [
            'ayah' => $ayah,
            'tafseer' => $tafseer,
        ]);
    }
}
