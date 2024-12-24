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

    // Show the Advanced Search page
    public function advancedSearch()
    {
        return view('advanced-search'); // Load the advanced search Blade file
    }

    // Handle the search request from the Basic Search page
    public function search(Request $request)
    {
        // Get the target collection from the "Search in" dropdown
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
                $logic = strtolower($condition['logic'] ?? 'and'); // Default to "and" logic
                $value = $condition['value']; // Value to search for

                // Apply conditions based on the logic
                if ($logic === 'or') {
                    $query->orWhere(function ($subQuery) use ($value) {
                        // Check all fields for a match
                        $subQuery->orWhereRaw(['$text' => ['$search' => $value]]);
                    });
                } elseif ($logic === 'not') {
                    $query->where(function ($subQuery) use ($value) {
                        // Exclude records matching the value
                        $subQuery->whereRaw(['$text' => ['$search' => $value]]);
                    });
                } else {
                    // Default: "and" condition
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
}