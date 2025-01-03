<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Surah;
use App\Models\Ayah;

class WordController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the list of Surahs
        $surahs = Surah::all();

        // Get selected Surah, Ayah, and Word from the request
        $surahId = $request->get('surah_id', '1');
        $ayahIndex = $request->get('ayah_index', '1');
        $wordIndex = $request->get('word_index', '1');

        // Fetch the total Ayahs in the selected Surah
        $totalAyahs = Ayah::where('surah_id', $surahId)->count();

        // Fetch the total Words in the selected Ayah
        $totalWords = Word::where('surah_id', $surahId)
            ->where('ayah_index', $ayahIndex)
            ->count();

        // Fetch the current Word
        $word = Word::where('surah_id', $surahId)
            ->where('ayah_index', $ayahIndex)
            ->where('word_index', $wordIndex)
            ->first();

        // If no Word is found, default to the first Word
        if (!$word) {
            $word = Word::where('word_key', '1:1:1')->first();
        }

        // Fetch the Surah name
        $surah = Surah::where('_id', $surahId)->first();
        $surahName = $surah ? $surah->tname : "Surah $surahId";

        // Fetch the Ayah text
        $ayah = Ayah::where('surah_id', $surahId)
            ->where('ayah_index', $ayahIndex)
            ->first();
        $ayahText = $ayah ? $ayah->text : "Ayah not found";

        return view('word', compact('word', 'surahId', 'ayahIndex', 'surahName', 'ayahText', 'surahs', 'totalAyahs', 'totalWords'));
    }

    public function verify(Request $request, $wordKey)
    {
        // Fetch the current word
        $word = Word::where('word_key', $wordKey)->first();

        if ($word) {
            // Update the word text and mark it as verified
            $word->text = $request->input('text'); // Update the text
            $word->isVerified = true; // Mark as verified
            $word->save(); // Save the changes
        }

        // Redirect to the same word or the next one
        return redirect()->route('word.index', [
            'surah_id' => $word->surah_id,
            'ayah_index' => $word->ayah_index,
            'word_index' => $word->word_index,
        ]);
    }

    public function next($wordKey)
    {
        // Split the word_key into surah_id, ayah_index, and word_index
        [$currentSurah, $currentAyah, $currentWord] = explode(':', $wordKey);

        // Fetch the next word within the current ayah
        $nextWord = Word::where('surah_id', $currentSurah)
            ->where('ayah_index', $currentAyah)
            ->where('word_index', '>', $currentWord)
            ->orderBy('word_index')
            ->first();

        // If no next word exists in the current ayah, go to the first word of the next ayah
        if (!$nextWord) {
            $nextAyah = Word::where('surah_id', $currentSurah)
                ->where('ayah_index', '>', $currentAyah)
                ->orderBy('ayah_index')
                ->first();

            if ($nextAyah) {
                $nextWord = Word::where('surah_id', $nextAyah->surah_id)
                    ->where('ayah_index', $nextAyah->ayah_index)
                    ->orderBy('word_index')
                    ->first();
            }
        }

        // If no next word exists, stay on the current one
        if (!$nextWord) {
            return redirect()->route('word.index', [
                'surah_id' => $currentSurah,
                'ayah_index' => $currentAyah,
                'word_index' => $currentWord,
            ]);
        }

        // Redirect to the next word
        return redirect()->route('word.index', [
            'surah_id' => $nextWord->surah_id,
            'ayah_index' => $nextWord->ayah_index,
            'word_index' => $nextWord->word_index,
        ]);
    }

    public function back($wordKey)
    {
        // Split the word_key into surah_id, ayah_index, and word_index
        [$currentSurah, $currentAyah, $currentWord] = explode(':', $wordKey);

        // Fetch the previous word within the current ayah
        $previousWord = Word::where('surah_id', $currentSurah)
            ->where('ayah_index', $currentAyah)
            ->where('word_index', '<', $currentWord)
            ->orderBy('word_index', 'desc')
            ->first();

        // If no previous word exists in the current ayah, go to the last word of the previous ayah
        if (!$previousWord) {
            $previousAyah = Word::where('surah_id', $currentSurah)
                ->where('ayah_index', '<', $currentAyah)
                ->orderBy('ayah_index', 'desc')
                ->first();

            if ($previousAyah) {
                $previousWord = Word::where('surah_id', $previousAyah->surah_id)
                    ->where('ayah_index', $previousAyah->ayah_index)
                    ->orderBy('word_index', 'desc')
                    ->first();
            }
        }

        // If no previous word exists, stay on the current one
        if (!$previousWord) {
            return redirect()->route('word.index', [
                'surah_id' => $currentSurah,
                'ayah_index' => $currentAyah,
                'word_index' => $currentWord,
            ]);
        }

        // Redirect to the previous word
        return redirect()->route('word.index', [
            'surah_id' => $previousWord->surah_id,
            'ayah_index' => $previousWord->ayah_index,
            'word_index' => $previousWord->word_index,
        ]);
    }
}
