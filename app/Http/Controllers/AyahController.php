<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ayah;
use App\Models\Surah;

class AyahController extends Controller
{
    public function index($ayahKey = null)
    {
        // Fetch the current ayah
        $ayah = Ayah::where('ayah_key', $ayahKey)->first();

        // If no ayah is found, default to Surah 1, Ayah 1
        if (!$ayah) {
            $ayah = Ayah::where('ayah_key', '1:1')->first();
        }

        // Use surah_id from the Ayahs collection to query the Surahs collection
        $surahId = $ayah->surah_id; // Surah ID as a string from the ayahs collection

        // Fetch the Surah document from the Surahs collection
        $surah = Surah::where('_id', $surahId)->first();

        // Get the tname field or fallback to "Surah X" if not found
        $surahName = $surah ? $surah->tname : "Surah $surahId";

        // Pass data to the view
        return view('ayah', compact('ayah', 'surahName'));
    }


    public function verify(Request $request, $ayahKey)
    {
        // Fetch the current ayah
        $ayah = Ayah::where('ayah_key', $ayahKey)->first();

        if ($ayah) {
            // Update the ayah text and mark it as verified
            $ayah->update([
                'text' => $request->input('text'), // Updated text from the form
                'isVerified' => true,
            ]);
        }

        // Redirect to the same ayah or the next one
        return redirect()->route('ayah.next', ['ayahKey' => $ayahKey]);
    }

    public function next($ayahKey)
    {
        // Split the ayah_key into surah_id and ayah_index
        [$currentSurah, $currentAyah] = explode(':', $ayahKey);

        // Fetch the next ayah within the current surah
        $nextAyah = Ayah::where('surah_id', $currentSurah)
            ->where('ayah_index', '>', $currentAyah)
            ->orderBy('ayah_index')
            ->first();

        // If no next ayah exists in the current surah, go to the first ayah of the next surah
        if (!$nextAyah) {
            $nextSurah = Ayah::where('surah_id', '>', $currentSurah)
                ->orderBy('surah_id')
                ->first();

            if ($nextSurah) {
                $nextAyah = Ayah::where('surah_id', $nextSurah->surah_id)
                    ->orderBy('ayah_index')
                    ->first();
            }
        }

        // If no next ayah exists, stay on the current one
        if (!$nextAyah) {
            return redirect()->route('ayah.index', ['ayahKey' => $ayahKey]);
        }

        // Redirect to the next ayah
        return redirect()->route('ayah.index', ['ayahKey' => $nextAyah->ayah_key]);
    }

    public function back($ayahKey)
    {
        // Split the ayah_key into surah_id and ayah_index
        [$currentSurah, $currentAyah] = explode(':', $ayahKey);

        // Fetch the previous ayah within the current surah
        $previousAyah = Ayah::where('surah_id', $currentSurah)
            ->where('ayah_index', '<', $currentAyah)
            ->orderBy('ayah_index', 'desc')
            ->first();

        // If no previous ayah exists in the current surah, go to the last ayah of the previous surah
        if (!$previousAyah) {
            $previousSurah = Ayah::where('surah_id', '<', $currentSurah)
                ->orderBy('surah_id', 'desc')
                ->first();

            if ($previousSurah) {
                $previousAyah = Ayah::where('surah_id', $previousSurah->surah_id)
                    ->orderBy('ayah_index', 'desc')
                    ->first();
            }
        }

        // If no previous ayah exists, stay on the current one
        if (!$previousAyah) {
            return redirect()->route('ayah.index', ['ayahKey' => $ayahKey]);
        }

        // Redirect to the previous ayah
        return redirect()->route('ayah.index', ['ayahKey' => $previousAyah->ayah_key]);
    }
}