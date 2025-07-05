<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Word;
use App\Models\Ayah;
use App\Models\Surah;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Http\Resources\V1\WordResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIWordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WordResource::collection(Word::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreWordRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($key)
    {
        $word = Word::where('word_key', $key)->firstOrFail();

        return new WordResource($word);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Word $word)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateWordRequest $request, Word $word)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Word $word)
    // {
    //     //
    // }

    public function search(Request $request)
{
    $query = $request->input('q', '');
    $page = $request->input('page', 1);
    $perPage = $request->input('per_page', 20);
    $type = $request->input('type', 'all');
    $wordText = $request->input('word_text');
    $juzNumber = $request->input('juz');

    $wordQuery = Word::query();
    $matchingWords = null;

    // If word_text is provided, search for occurrences
    if ($wordText) {
        // First try exact match
        $exactMatchCount = Word::where('text', $wordText)->count();
        
        if ($exactMatchCount > 0) {
            // Exact match found
            $wordQuery->where('text', $wordText);
        } else {
            // No exact match, try without diacritics
            $strippedWordText = $this->stripDiacritics($wordText);
            
            // Get matching words (this part could be optimized with a 'stripped_text' field)
            $allWords = Word::take(100000)->get();
            $matchingWords = $allWords->filter(function($word) use ($strippedWordText) {
                $wordWithoutDiacritics = $this->stripDiacritics($word->text);
                return $wordWithoutDiacritics === $strippedWordText;
            });
            
            if ($matchingWords->isEmpty()) {
                // No matches even after stripping diacritics
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'words' => [],
                        'pagination' => [
                            'current_page' => (int)$page,
                            'per_page' => (int)$perPage,
                            'total' => 0,
                            'total_pages' => 0
                        ]
                    ]
                ]);
            }
            
            // Get the IDs of matching words to use in a query
            $matchingIds = $matchingWords->pluck('_id')->toArray();
            $wordQuery->whereIn('_id', $matchingIds);
        }
        
        if ($juzNumber) {
            $wordQuery->where('juz_id', (string)$juzNumber);
        }
    }
    // Regular search logic for query (q parameter)
    else if (!empty($query)) {
        // ... (existing code for regular search)
    }

    // Continue with pagination and response formatting
    if ($matchingWords !== null) {
        // If we used the diacritic stripping approach, we need to handle pagination manually
        $total = $matchingWords->count();
        $pagedWords = $matchingWords
            ->skip(($page - 1) * $perPage)
            ->take($perPage);
        
        // Convert collection to array for response
        $words = $pagedWords->values()->all();
    } else {
        // Standard database query approach
        $total = $wordQuery->count();
        $words = $wordQuery->skip(($page - 1) * $perPage)
                          ->take($perPage)
                          ->get();
    }

    // Get all unique ayah_keys from the words
    $ayahKeys = collect($words)->pluck('ayah_key')->unique()->toArray();

    // Fetch all relevant ayahs in a single query
    $ayahsMap = Ayah::whereIn('ayah_key', $ayahKeys)
                    ->get()
                    ->keyBy('ayah_key');

    // Map the words with their corresponding ayah text
    $mappedWords = collect($words)->map(function ($word) use ($ayahsMap) {
        $ayah = $ayahsMap->get($word->ayah_key);
        
        return [
            'word_id' => (string)$word->_id,
            'word_text' => $word->text,
            'translation' => $word->translation,
            'transliteration' => $word->transliteration,
            'chapter_id' => $word->surah_id,
            'verse_number' => $word->ayah_index,
            'verse_text' => $ayah ? $ayah->text : null,
            'ayah_key' => $word->ayah_key,
            'juz_number' => $word->juz_id,
            'position' => $word->word_index
        ];
    });

    return response()->json([
        'status' => 'success',
        'data' => [
            'words' => $mappedWords,
            'pagination' => [
                'current_page' => (int)$page,
                'per_page' => (int)$perPage,
                'total' => $total,
                'total_pages' => (int)ceil($total / $perPage)
            ]
        ]
    ]);
}

public function getWordJuzDistribution(Request $request)
{
    $wordText = $request->input('word_text');
    
    if (empty($wordText)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Word text is required'
        ], 400);
    }

    // First try exact matching
    $wordQuery = Word::query();
    $wordQuery->where('text', $wordText);
    $exactMatches = $wordQuery->count();

    // If no results found with exact match, try to match without diacritics
    if ($exactMatches == 0) {
        // Strip diacritics from search query
        $strippedWordText = $this->stripDiacritics($wordText);
        
        // Get all words from collection (limiting to a reasonable number for performance)
        $allWords = Word::take(90000)->get(); // Adjust limit based on your collection size
        
        // Filter words that match when diacritics are stripped
        $wordOccurrences = $allWords->filter(function($word) use ($strippedWordText) {
            $wordWithoutDiacritics = $this->stripDiacritics($word->text);
            return $wordWithoutDiacritics === $strippedWordText;
        });
        
        if ($wordOccurrences->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Word not found'
            ], 404);
        }
        
        // Get distribution using collection methods since we can't use MongoDB aggregation directly
        $juzDistribution = [];
        foreach ($wordOccurrences as $word) {
            $juzId = (string)$word->juz_id;
            if (!isset($juzDistribution[$juzId])) {
                $juzDistribution[$juzId] = 0;
            }
            $juzDistribution[$juzId]++;
        }
    } else {
        // Original code for exact matches
        $firstOccurrence = Word::where('text', $wordText)
            ->orderBy('surah_id', 'asc')
            ->orderBy('ayah_index', 'asc')
            ->orderBy('word_index', 'asc')
            ->first();

        // Get distribution using aggregation
        $distribution = Word::raw(function($collection) use ($wordText) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'text' => $wordText
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$juz_id',
                        'count' => ['$sum' => 1]
                    ]
                ]
            ]);
        });

        // Convert to array with all juz (1-30)
        $juzDistribution = [];
        foreach ($distribution as $item) {
            $juzDistribution[(string)$item->_id] = $item->count;
        }
    }
    
    // Fill missing juz with zeros
    for ($i = 1; $i <= 30; $i++) {
        if (!isset($juzDistribution[(string)$i])) {
            $juzDistribution[(string)$i] = 0;
        }
    }
    ksort($juzDistribution);

    // Count total occurrences
    $totalOccurrences = array_sum($juzDistribution);

    return response()->json([
        'status' => 'success',
        'data' => [
            'word_text' => $wordText,
            'total_occurrences' => $totalOccurrences,
            'juz_distribution' => $juzDistribution
        ]
    ]);
}
    public function getWordsChaptersDistribution(Request $request)
    {
        try {
            $words = $request->input('words', []);
            
            $distribution = Word::raw(function($collection) use ($words) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'text' => ['$in' => $words]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => '$surah_id',
                            'count' => ['$sum' => 1]
                        ]
                    ],
                    [
                        '$sort' => [
                            'count' => -1
                        ]
                    ]
                ]);
            });
    
            $result = [];
            foreach ($distribution as $item) {
                $result[(string)$item->_id] = $item->count;
            }
    
            return response()->json([
                'status' => 'success',
                'data' => [
                    'chapters' => $result
                ]
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getChapterWordCounts()
    {
        try {
            $wordCounts = Surah::select('_id', 'word_count')
                              ->orderBy('_id', 'asc')
                              ->get()
                              ->mapWithKeys(function ($chapter) {
                                  return [(string)$chapter->_id => (int)$chapter->word_count];
                              });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'wordCounts' => $wordCounts
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
 * Get detailed information about a specific word in the Quran,
 * with support for matching words regardless of diacritics.
 */
public function getWordDetails(Request $request)
{
    $wordText = $request->input('word_text');
    
    if (empty($wordText)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Word text is required'
        ], 400);
    }

    // First try exact matching
    $wordQuery = Word::query();
    $wordQuery->where('text', $wordText);
    $exactMatches = $wordQuery->count();

    // If no results found with exact match, try to match without diacritics
    if ($exactMatches == 0) {
        // Strip diacritics from search query
        $strippedWordText = $this->stripDiacritics($wordText);
        
        // Get all words from collection (limiting to a reasonable number for performance)
        // For production, you should consider adding a 'stripped_text' field to your collection 
        // and indexing it for better performance
        $allWords = Word::take(10000)->get(); // Adjust limit based on your collection size
        
        // Filter words that match when diacritics are stripped
        $wordOccurrences = $allWords->filter(function($word) use ($strippedWordText) {
            $wordWithoutDiacritics = $this->stripDiacritics($word->text);
            return $wordWithoutDiacritics === $strippedWordText;
        });
    } else {
        $wordOccurrences = $wordQuery->get();
    }
    
    if ($wordOccurrences->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Word not found'
        ], 404);
    }

    // Get the first occurrence
    $firstOccurrence = $wordOccurrences->sortBy([
        ['surah_id', 'asc'],
        ['ayah_index', 'asc'],
        ['word_index', 'asc']
    ])->first();

    // Get the ayah (verse) text for the first occurrence
    $ayah = Ayah::where('ayah_key', $firstOccurrence->ayah_key)->first();
    
    // Get surah (chapter) details
    $surah = Surah::find($firstOccurrence->surah_id);

    // Count total occurrences
    $totalOccurrences = $wordOccurrences->count();

    // Prepare distribution data
    $juzDistribution = $this->calculateJuzDistribution($wordOccurrences);

    // Construct response
    $result = [
        'word_text' => $firstOccurrence->text,
        'translation' => $firstOccurrence->translation,
        'transliteration' => $firstOccurrence->transliteration,
        'total_occurrences' => $totalOccurrences,
        'first_occurrence' => [
            'chapter_id' => $firstOccurrence->surah_id,
            'verse_number' => $firstOccurrence->ayah_index,
            'surah_name' => $surah ? $surah->name_arabic : null,
            'surah_name_english' => $surah ? $surah->name_complex : null,
            'page_id' => $surah && isset($surah->pages[0]->_id) ? (string)$surah->pages[0]->_id : null,
            'juz_id' => $firstOccurrence->juz_id,
            'verse_text' => $ayah ? $ayah->text : null,
            'ayah_key' => $firstOccurrence->ayah_key,
            'audio_url' => $firstOccurrence->audio_url ?? null
        ],
        'juz_distribution' => $juzDistribution
    ];

    return response()->json([
        'status' => 'success',
        'data' => $result
    ]);
}

/**
 * Helper function to strip diacritics from Arabic text
 */
private function stripDiacritics($text)
{
    // Log original input
    // \Log::info("Original text: " . $text);
    
    // Arabic diacritical marks to be removed
    $diacritics = [
        // Fatha, Damma, Kasra
        'َ', 'ُ', 'ِ',
        // Tanwin (double) marks
        'ً', 'ٌ', 'ٍ',
        // Sukun, Shadda
        'ْ', 'ّ',
        // Superscript Alif
        'ٰ',
        // Maddah
        'ٓ',
        // Hamza
        'ٔ', 'ٕ'
    ];

    // Also need to handle the initial alef with hamza below vs plain alef
    $normalizedText = str_replace('ٱ', 'ا', $text); // Replace Alef with Hamza below with plain Alef
    
    // Replace diacritics with empty string
    $strippedText = str_replace($diacritics, '', $normalizedText);
    
    // Log the result
    // \Log::info("Stripped text: " . $strippedText);
    
    return $strippedText;
}

/**
 * Calculate the distribution of word occurrences across all juz
 */
private function calculateJuzDistribution($wordOccurrences)
{
    $distribution = [];
    
    // Group occurrences by juz_id
    foreach ($wordOccurrences as $occurrence) {
        $juzId = (string)$occurrence->juz_id;
        if (!isset($distribution[$juzId])) {
            $distribution[$juzId] = 0;
        }
        $distribution[$juzId]++;
    }
    
    // Ensure all juz are included (1-30)
    for ($i = 1; $i <= 30; $i++) {
        if (!isset($distribution[(string)$i])) {
            $distribution[(string)$i] = 0;
        }
    }
    
    ksort($distribution);
    
    return $distribution;
}
public function getWordFirstOccurrence(Request $request)
    {
        $wordText = $request->input('word_text');
        
        if (empty($wordText)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Word text is required'
            ], 400);
        }

        // First try exact matching
        $wordQuery = Word::query();
        $wordQuery->where('text', $wordText);
        
        $exactMatch = $wordQuery->orderBy('surah_id', 'asc')
                              ->orderBy('ayah_index', 'asc')
                              ->orderBy('word_index', 'asc')
                              ->first();

        // If no results found with exact match, try to match without diacritics
        if (!$exactMatch) {
            // Strip diacritics from search query
            $strippedWordText = $this->stripDiacritics($wordText);
            
            // Get words from collection (limiting to a reasonable number for performance)
            $allWords = Word::take(90000)->get(); // Adjust limit based on your collection size
            
            // Filter words that match when diacritics are stripped
            $matchingWords = $allWords->filter(function($word) use ($strippedWordText) {
                $wordWithoutDiacritics = $this->stripDiacritics($word->text);
                return $wordWithoutDiacritics === $strippedWordText;
            });
            
            if ($matchingWords->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Word not found'
                ], 404);
            }
            
            // Sort to find the first occurrence
            $firstOccurrence = $matchingWords->sortBy([
                ['surah_id', 'asc'],
                ['ayah_index', 'asc'],
                ['word_index', 'asc']
            ])->first();
        } else {
            $firstOccurrence = $exactMatch;
        }

        // Get the ayah (verse) text for the first occurrence
        $ayah = Ayah::where('ayah_key', $firstOccurrence->ayah_key)->first();
        
        // Get surah (chapter) details
        $surah = Surah::find($firstOccurrence->surah_id);

        // Format the response
        $result = [
            'word_key' => $firstOccurrence->word_key,
            'chapter_id' => $firstOccurrence->surah_id,
            'verse_number' => $firstOccurrence->ayah_index,
            'surah_name' => $surah ? $surah->name . ' (' . $surah->tname . ')' : 'Surah ' . $firstOccurrence->surah_id,
            'page_id' => $firstOccurrence->page_id,
            'juz_id' => $firstOccurrence->juz_id,
            'verse_text' => $ayah ? $ayah->text : '',
            'audio_url' => $firstOccurrence->audio_url ?? null
        ];

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }
}
