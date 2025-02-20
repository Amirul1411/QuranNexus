<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Word;
use App\Models\Ayah;
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

    // If word_text is provided, search for occurrences
    if ($wordText) {
        $wordQuery->where('text', $wordText);
        if ($juzNumber) {
            $wordQuery->where('juz_id', (string)$juzNumber);
        }
    }
    // Normal search
    else if (!empty($query)) {
        switch ($type) {
            case 'arabic':
                $wordQuery->where('text', 'regex', '/' . $query . '/i');
                break;
            case 'translation':
                $wordQuery->where('translation', 'regex', '/' . $query . '/i');
                break;
            default:
                $wordQuery->where(function($q) use ($query) {
                    $q->where('text', 'regex', '/' . $query . '/i')
                      ->orWhere('translation', 'regex', '/' . $query . '/i');
                });
        }
    }

    $total = $wordQuery->count();
    $words = $wordQuery->skip(($page - 1) * $perPage)
                      ->take($perPage)
                      ->get();

    // Get all unique ayah_keys from the words
    $ayahKeys = $words->pluck('ayah_key')->unique()->toArray();

    // Fetch all relevant ayahs in a single query
    $ayahsMap = Ayah::whereIn('ayah_key', $ayahKeys)
                    ->get()
                    ->keyBy('ayah_key');

    // Map the words with their corresponding ayah text
    $mappedWords = $words->map(function ($word) use ($ayahsMap) {
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

        // Get first occurrence for reference
        $firstOccurrence = Word::where('text', $wordText)
            ->orderBy('surah_id', 'asc')
            ->orderBy('ayah_index', 'asc')
            ->orderBy('word_index', 'asc')
            ->first();

        if (!$firstOccurrence) {
            return response()->json([
                'status' => 'error',
                'message' => 'Word not found'
            ], 404);
        }

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
}
