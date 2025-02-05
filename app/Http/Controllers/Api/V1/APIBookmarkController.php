<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Word;
use MongoDB\BSON\ObjectId;

class APIBookmarkController extends Controller
{
    public function addBookmark(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|string|in:chapter,verse,word,quote',
                'item_id' => 'required|string',
                'word_text' => 'required_if:type,word',
                'translation' => 'required_if:type,word',
                'transliteration' => 'nullable|string',
                'total_occurrences' => 'required_if:type,word|integer',
                'first_occurrence' => 'required_if:type,word|array',
                'first_occurrence.word_key' => 'required_if:type,word|string',
                'first_occurrence.chapter_id' => 'required_if:type,word|string',
                'first_occurrence.verse_number' => 'required_if:type,word|string',
                'first_occurrence.surah_name' => 'required_if:type,word|string',
                'first_occurrence.page_id' => 'required_if:type,word|string',
                'first_occurrence.juz_id' => 'required_if:type,word|string',
                'first_occurrence.verse_text' => 'required_if:type,word|string',
                'first_occurrence.audio_url' => 'nullable|string',
            ]);

            // Get authenticated user
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            switch($request->type) {
                case 'chapter':
                    // Existing chapter logic
                    if (in_array($request->item_id, $user->surah_bookmarks ?? [])) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Chapter already bookmarked'
                        ], 409);
                    }
                    $user->push('surah_bookmarks', $request->item_id);
                    break;

                case 'verse':
                    // Existing verse logic
                    if (in_array($request->item_id, $user->ayah_bookmarks ?? [])) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Verse already bookmarked'
                        ], 409);
                    }
                    $user->push('ayah_bookmarks', $request->item_id);
                    $user->push('ayah_bookmarks_mobile', [
                        'ayah_id' => $request->item_id,
                        'chapter_id' => $request->chapter_id,
                        'notes' => $request->notes ?? '',
                        'created_at' => now()->toDateTimeString()
                    ]);
                    break;

                case 'word':
                    // New word bookmark logic
                    if ($user->word_bookmarks && collect($user->word_bookmarks)->contains('word_text', $request->word_text)) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Word already bookmarked'
                        ], 409);
                    }
                    $wordBookmark = [
                        'word_text' => $request->word_text,
                        'translation' => $request->translation,
                        'transliteration' => $request->transliteration,
                        'total_occurrences' => $request->total_occurrences,
                        'first_occurrence' => [
                            'word_key' => $request->first_occurrence['word_key'],
                            'chapter_id' => $request->first_occurrence['chapter_id'],
                            'verse_number' => $request->first_occurrence['verse_number'],
                            'surah_name' => $request->first_occurrence['surah_name'],
                            'page_id' => $request->first_occurrence['page_id'],
                            'juz_id' => $request->first_occurrence['juz_id'],
                            'verse_text' => $request->first_occurrence['verse_text'],
                            'audio_url' => $request->first_occurrence['audio_url']
                        ],
                        'bookmark_date' => now()->toDateTimeString()
                    ];
                    
                    $user->push('word_bookmarks', $wordBookmark);
                    break;

                case 'quote':
                    // New quote bookmark logic
                    if (in_array($request->item_id, array_column($user->quote_bookmarks ?? [], 'quote_id'))) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Quote already bookmarked'
                        ], 409);
                    }
                    $quoteBookmark = [
                        'quote_id' => $request->item_id,
                        'title' => $request->title,
                        'description' => $request->description,
                        'source' => $request->source
                    ];
                    $user->push('quote_bookmarks', $quoteBookmark);
                    break;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Bookmark added successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add bookmark: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeBookmark(Request $request, $type, $itemId)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            switch($type) {
                case 'chapter':
                    $user->pull('surah_bookmarks', $itemId);
                    break;
                case 'verse':
                    $user->pull('ayah_bookmarks', $itemId);
                    $user->pull('ayah_bookmarks_mobile', ['ayah_id' => $itemId]);
                    break;
                case 'word':
                    $user->pull('word_bookmarks', ['word_text' => $itemId]);
                    break;
                case 'quote':
                    $user->pull('quote_bookmarks', ['quote_id' => $itemId]);
                    break;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Bookmark removed successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove bookmark: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getBookmarks()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            return response()->json([
                'status' => 'success',
                'user_id' => $user->_id,
                'bookmarks' => [
                    'chapters' => $user->surah_bookmarks ?? [],
                    'verses' => $user->ayah_bookmarks_mobile ?? [],
                    'words' => $user->word_bookmarks ?? [],
                    'quotes' => $user->quote_bookmarks ?? []
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch bookmarks: ' . $e->getMessage()
            ], 500);
        }
    }


    public function migrateWordBookmarks(Request $request)
{
    try {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }

        $oldBookmarks = $user->word_bookmarks ?? [];
        $newBookmarks = [];

        foreach ($oldBookmarks as $bookmark) {
            // Get first occurrence details from the Word collection
            $word = Word::where('text', $bookmark['word_text'])->first();
            
            if ($word) {
                $newBookmarks[] = [
                    'word_text' => $bookmark['word_text'],
                    'translation' => $bookmark['translation'],
                    'transliteration' => $bookmark['transliteration'],
                    'total_occurrences' => Word::where('text', $bookmark['word_text'])->count(),
                    'first_occurrence' => [
                        'word_key' => "{$word->surah_id}:{$word->ayah_index}:{$word->word_index}",
                        'chapter_id' => $word->surah_id,
                        'verse_number' => $word->ayah_index,
                        'surah_name' => $bookmark['surah_name'],
                        'page_id' => $word->page_id,
                        'juz_id' => $word->juz_id,
                        'verse_text' => Word::where('ayah_key', $word->ayah_key)
                                          ->orderBy('word_index')
                                          ->pluck('text')
                                          ->join(' '),
                        'audio_url' => $word->audio_url
                    ],
                    'bookmark_date' => now()->toDateTimeString()
                ];
            }
        }

        // Replace old bookmarks with new structure
        $user->word_bookmarks = $newBookmarks;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Word bookmarks migrated successfully',
            'count' => count($newBookmarks)
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to migrate bookmarks: ' . $e->getMessage()
        ], 500);
    }
}
}