<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ayah;
use App\Models\Surah;

class AyahController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the list of Surahs
        $surahs = Surah::all();

        // Get selected Surah and Ayah from the request
        $surahId = $request->get('surah_id', '1');
        $ayahIndex = $request->get('ayah_index', '1');

        // Fetch the total Ayahs in the selected Surah
        $totalAyahs = Ayah::where('surah_id', $surahId)->count();

        // Fetch the current Ayah
        $ayah = Ayah::where('surah_id', $surahId)
            ->where('ayah_index', $ayahIndex)
            ->first();

        // If no Ayah is found, default to Surah 1, Ayah 1
        if (!$ayah) {
            $ayah = Ayah::where('ayah_key', '1:1')->first();
        }

        // Fetch the Surah name
        $surah = Surah::where('_id', $surahId)->first();
        $surahName = $surah ? $surah->tname : "Surah $surahId";

        return view('ayah', compact('ayah', 'surahId', 'ayahIndex', 'surahName', 'surahs', 'totalAyahs'));
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

        return redirect()->route('ayah.index', ['surah_id' => $ayah->surah_id, 'ayah_index' => $ayah->ayah_index]);
    }

    public function next($ayahKey)
    {
        [$currentSurah, $currentAyah] = explode(':', $ayahKey);

        $nextAyah = Ayah::where('surah_id', $currentSurah)
            ->where('ayah_index', '>', $currentAyah)
            ->orderBy('ayah_index')
            ->first();

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

        if (!$nextAyah) {
            return redirect()->route('ayah.index', ['surah_id' => $currentSurah, 'ayah_index' => $currentAyah]);
        }

        return redirect()->route('ayah.index', ['surah_id' => $nextAyah->surah_id, 'ayah_index' => $nextAyah->ayah_index]);
    }

    public function back($ayahKey)
    {
        [$currentSurah, $currentAyah] = explode(':', $ayahKey);

        $previousAyah = Ayah::where('surah_id', $currentSurah)
            ->where('ayah_index', '<', $currentAyah)
            ->orderBy('ayah_index', 'desc')
            ->first();

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

        if (!$previousAyah) {
            return redirect()->route('ayah.index', ['surah_id' => $currentSurah, 'ayah_index' => $currentAyah]);
        }

        return redirect()->route('ayah.index', ['surah_id' => $previousAyah->surah_id, 'ayah_index' => $previousAyah->ayah_index]);
    }
}
