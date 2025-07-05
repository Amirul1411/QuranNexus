<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juz;
use App\Models\Page;
use App\Models\Surah;
use App\Models\Ayah;
use App\Models\Word;

class SearchController extends Controller
{
    // Show the Basic Search page
    public function basicSearch()
    {
        return view('basic-search'); // Load the basic search Blade file
    }

    // Handle the search request from the Basic Search page
    public function search(Request $request)
    {
        $searchIn = $request->input('search_in'); // The collection to search
        $conditions = $request->input('conditions', []); // Array of search conditions

        // Get the appropriate model for the selected collection
        $model = $this->getModel($searchIn);
        if (!$model) {
            return back()->withErrors(['error' => 'Invalid collection selected.']);
        }

        // Initialize the query using the selected model
        $query = $model::query();

        // Apply search conditions to the query
        foreach ($conditions as $condition) {
            if (!empty($condition['value'])) { // Check if the condition value is not empty
                $value = $condition['value']; // Value to search for

                if ($searchIn === 'surahs') {
                    // Partial match for Surahs
                    $query->where(function ($subQuery) use ($value) {
                        $subQuery->where('tname', 'LIKE', "%$value%")
                                    ->orWhere('ename', 'LIKE', "%$value%")
                                    ->orWhere('name', 'LIKE', "%$value%");
                    });
                } elseif ($searchIn === 'ayahs') {
                    // Match Ayahs based on text or Surah relationship
                    $matchingSurahs = Surah::where('tname', 'LIKE', "%$value%")
                                            ->orWhere('ename', 'LIKE', "%$value%")
                                            ->orWhere('name', 'LIKE', "%$value%")
                                            ->pluck('_id');
                    $query->where('text', 'LIKE', "%$value%")
                            ->orWhereIn('surah_id', $matchingSurahs);
                } elseif ($searchIn === 'words') {
                    // Partial match for Words
                    $query->where('text', 'LIKE', "%$value%")
                            ->orWhere('transliteration', 'LIKE', "%$value%")
                            ->orWhere('translation', 'LIKE', "%$value%");
                } else {
                    // Default case for other collections
                    $query->whereRaw(['$text' => ['$search' => $value]]);
                }
            }
        }

        // Execute the query and fetch the results
        $results = $query->get();

        // Return the results to the view
        return view('search-results', [
            'results' => $results,
            'searchIn' => ucfirst($searchIn), // Capitalize the collection name for display
            'searchTerm' => $conditions[0]['value'] ?? '', // For displaying the term in the view
        ]);
    }

    /**
     * Get the appropriate model for the selected collection.
     *
     * @param string $searchIn
     * @return mixed
     */
    private function getModel($searchIn)
    {
        return match ($searchIn) {
            'juzs' => new Juz(),
            'pages' => new Page(),
            'surahs' => new Surah(),
            'ayahs' => new Ayah(),
            'words' => new Word(),
            default => null,
        };
    }

    /**
     * Show details for a specific result.
     *
     * @param string $surah_id
     * @param int $ayah_index
     * @return \Illuminate\View\View
     */
    public function showDetails($surah_id, $ayah_index)
    {
        // Get Ayah Data
        $ayah = Ayah::where('surah_id', $surah_id)
                    ->where('ayah_index', $ayah_index)
                    ->first();

        // Get Surah Name
        $surah = Surah::where('_id', $surah_id)->first();
        $surah_name = $surah ? $surah->tname : 'Unknown Surah';

        // Get Word Data (if applicable)
        $word = Word::where('surah_id', $surah_id)
                    ->where('ayah_index', $ayah_index)
                    ->first();

        return view('result-details', [
            'surah_id' => $surah_id,
            'surah_name' => $surah_name,
            'ayah_index' => $ayah_index,
            'ayah_text' => $ayah->text ?? null,
            'juz_id' => $ayah->juz_id ?? null,
            'page_id' => $ayah->page_id ?? null,
            'isVerified' => $ayah->isVerified ?? false,
            'audio_url' => $ayah->audio_url ?? null,
            'word_text' => $word->text ?? null,
            'word_transliteration' => $word->transliteration ?? null,
            'word_translation' => $word->translation ?? null,
        ]);
    }

}