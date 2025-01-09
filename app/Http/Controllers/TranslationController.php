<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\Surah;
use App\Models\Ayah;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the list of Surahs
        $surahs = Surah::all();

        // Get selected Surah and Ayah from the request
        $surahId = $request->get('surah_id', '1');
        $ayahIndex = $request->get('ayah_index', '1');

        // Fetch the Ayah text for the selected Surah and Ayah
        $ayah = Ayah::where('surah_id', $surahId)
            ->where('ayah_index', $ayahIndex)
            ->first();

        // Fetch the translation for the selected Ayah
        $translation = Translation::where('surah_id', $surahId)
            ->where('ayah_index', $ayahIndex)
            ->first();

        // Fetch the total Ayahs in the selected Surah
        $totalAyahs = Ayah::where('surah_id', $surahId)->count();

        // Fetch the Surah name
        $surah = Surah::where('_id', $surahId)->first();
        $surahName = $surah ? $surah->tname : "Surah $surahId";

        return view('translation', compact('ayah', 'translation', 'surahId', 'ayahIndex', 'surahName', 'surahs', 'totalAyahs'));
    }

    public function verify(Request $request, $ayahKey)
    {
        // Fetch the current translation
        $translation = Translation::where('ayah_key', $ayahKey)->first();

        if ($translation) {
            // Update the translation text
            $translation->update([
                'text' => $request->input('text'), // Updated text from the form
            ]);
        }

        return redirect()->route('translation.index', [
            'surah_id' => $translation->surah_id,
            'ayah_index' => $translation->ayah_index
        ]);
    }

    public function next($ayahKey)
    {
        [$currentSurah, $currentAyah] = explode(':', $ayahKey);

        $nextTranslation = Translation::where('surah_id', $currentSurah)
            ->where('ayah_index', '>', $currentAyah)
            ->orderBy('ayah_index')
            ->first();

        if (!$nextTranslation) {
            $nextSurah = Translation::where('surah_id', '>', $currentSurah)
                ->orderBy('surah_id')
                ->first();

            if ($nextSurah) {
                $nextTranslation = Translation::where('surah_id', $nextSurah->surah_id)
                    ->orderBy('ayah_index')
                    ->first();
            }
        }

        if (!$nextTranslation) {
            return redirect()->route('translation.index', [
                'surah_id' => $currentSurah,
                'ayah_index' => $currentAyah
            ]);
        }

        return redirect()->route('translation.index', [
            'surah_id' => $nextTranslation->surah_id,
            'ayah_index' => $nextTranslation->ayah_index
        ]);
    }

    public function back($ayahKey)
    {
        [$currentSurah, $currentAyah] = explode(':', $ayahKey);

        $previousTranslation = Translation::where('surah_id', $currentSurah)
            ->where('ayah_index', '<', $currentAyah)
            ->orderBy('ayah_index', 'desc')
            ->first();

        if (!$previousTranslation) {
            $previousSurah = Translation::where('surah_id', '<', $currentSurah)
                ->orderBy('surah_id', 'desc')
                ->first();

            if ($previousSurah) {
                $previousTranslation = Translation::where('surah_id', $previousSurah->surah_id)
                    ->orderBy('ayah_index', 'desc')
                    ->first();
            }
        }

        if (!$previousTranslation) {
            return redirect()->route('translation.index', [
                'surah_id' => $currentSurah,
                'ayah_index' => $currentAyah
            ]);
        }

        return redirect()->route('translation.index', [
            'surah_id' => $previousTranslation->surah_id,
            'ayah_index' => $previousTranslation->ayah_index
        ]);
    }
}