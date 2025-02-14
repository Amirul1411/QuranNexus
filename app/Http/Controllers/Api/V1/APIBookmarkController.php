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
                'type' => 'required|string|in:chapter,verse,word,quote,page',
                'item_properties' => 'required|array',
                'notes' => 'nullable|string'
            ]);

            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            // Initialize bookmarks structure if it doesn't exist
            if (!isset($user->bookmarks)) {
                $user->bookmarks = [
                    'chapters' => [],
                    'verses' => [],
                    'words' => [],
                    'quotes' => [],
                    'pages' => []
                ];
            }

            // Check for duplicates based on type
            $isDuplicate = false;
            switch ($request->type) {
                case 'chapter':
                    $isDuplicate = collect($user->bookmarks['chapters'])->contains(function ($item) use ($request) {
                        return $item['item_properties']['chapter_id'] === $request->item_properties['chapter_id'];
                    });
                    break;
                case 'verse':
                    $isDuplicate = collect($user->bookmarks['verses'])->contains(function ($item) use ($request) {
                        return $item['item_properties']['chapter_id'] === $request->item_properties['chapter_id'] 
                            && $item['item_properties']['verse_number'] === $request->item_properties['verse_number'];
                    });
                    break;
                case 'word':
                    $isDuplicate = collect($user->bookmarks['words'])->contains(function ($item) use ($request) {
                        return $item['item_properties']['word_text'] === $request->item_properties['word_text'];
                    });
                    break;
                case 'quote':
                    $isDuplicate = collect($user->bookmarks['quotes'])->contains(function ($item) use ($request) {
                        return $item['item_properties']['quote_id'] === $request->item_properties['quote_id'];
                    });
                    break;
                case 'page':
                    $isDuplicate = collect($user->bookmarks['pages'])->contains(function ($item) use ($request) {
                        return $item['item_properties']['page_id'] === $request->item_properties['page_id'];
                    });
                    break;
            }

            if ($isDuplicate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item already bookmarked'
                ], 409);
            }

            // Create new bookmark
            $newBookmark = [
                'item_properties' => $request->item_properties,
                'notes' => $request->notes ?? '',
                'created_at' => now()->toDateTimeString()
            ];

            // Add to appropriate array based on type
            $bookmarkType = $request->type . 's'; // Convert to plural
            $user->push('bookmarks.' . $bookmarkType, $newBookmark);

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

            $bookmarkType = $type . 's'; // Convert to plural
            if (!isset($user->bookmarks[$bookmarkType])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid bookmark type'
                ], 400);
            }

            $bookmarks = collect($user->bookmarks[$bookmarkType]);
            
            // Filter out the bookmark to remove based on type
            $updatedBookmarks = $bookmarks->filter(function ($bookmark) use ($type, $itemId) {
                switch ($type) {
                    case 'chapter':
                        return $bookmark['item_properties']['chapter_id'] !== $itemId;
                    case 'verse':
                        return $bookmark['item_properties']['verse_id'] !== $itemId;
                    case 'word':
                        return $bookmark['item_properties']['word_text'] !== $itemId;
                    case 'quote':
                        return $bookmark['item_properties']['quote_id'] !== $itemId;
                    case 'page':
                        return $bookmark['item_properties']['page_id'] !== $itemId;
                    default:
                        return true;
                }
            })->values()->all();

            // Update the specific bookmark type array
            $user->bookmarks[$bookmarkType] = $updatedBookmarks;
            $user->save();

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

            // Initialize empty structure if bookmarks don't exist
            $bookmarks = $user->bookmarks ?? [
                'chapters' => [],
                'verses' => [],
                'words' => [],
                'quotes' => [],
                'pages' => []
            ];

            return response()->json([
                'status' => 'success',
                'user_id' => $user->_id,
                'bookmarks' => $bookmarks
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch bookmarks: ' . $e->getMessage()
            ], 500);
        }
    }

    public function migrateBookmarks()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            // Initialize new bookmark structure
            $newBookmarks = [
                'chapters' => [],
                'verses' => [],
                'words' => [],
                'quotes' => [],
                'pages' => []
            ];

            // Migrate chapter bookmarks
            foreach ($user->surah_bookmarks ?? [] as $surahId) {
                $newBookmarks['chapters'][] = [
                    'item_properties' => [
                        'chapter_id' => $surahId
                    ],
                    'notes' => '',
                    'created_at' => now()->toDateTimeString()
                ];
            }

            // Migrate verse bookmarks
            foreach ($user->ayah_bookmarks_mobile ?? [] as $ayah) {
                $newBookmarks['verses'][] = [
                    'item_properties' => [
                        'verse_id' => $ayah['ayah_id'],
                        'chapter_id' => $ayah['chapter_id']
                    ],
                    'notes' => $ayah['notes'] ?? '',
                    'created_at' => $ayah['created_at']
                ];
            }

            // Migrate word bookmarks
            foreach ($user->word_bookmarks ?? [] as $word) {
                $newBookmarks['words'][] = [
                    'item_properties' => [
                        'word_text' => $word['word_text'],
                        'translation' => $word['translation'],
                        'transliteration' => $word['transliteration'],
                        'total_occurrences' => $word['total_occurrences'],
                        'first_occurrence' => $word['first_occurrence']
                    ],
                    'notes' => '',
                    'created_at' => $word['bookmark_date']
                ];
            }

            // Migrate quote bookmarks if they exist
            foreach ($user->quote_bookmarks ?? [] as $quote) {
                $newBookmarks['quotes'][] = [
                    'item_properties' => [
                        'quote_id' => $quote['quote_id'],
                        'title' => $quote['title'],
                        'description' => $quote['description'],
                        'source' => $quote['source']
                    ],
                    'notes' => '',
                    'created_at' => now()->toDateTimeString()
                ];
            }

            // Update user with new bookmark structure
            $user->bookmarks = $newBookmarks;
            
            // Clear old bookmark fields
            unset($user->surah_bookmarks);
            unset($user->ayah_bookmarks);
            unset($user->ayah_bookmarks_mobile);
            unset($user->word_bookmarks);
            unset($user->quote_bookmarks);
            
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Bookmarks migrated successfully',
                'counts' => [
                    'chapters' => count($newBookmarks['chapters']),
                    'verses' => count($newBookmarks['verses']),
                    'words' => count($newBookmarks['words']),
                    'quotes' => count($newBookmarks['quotes']),
                    'pages' => count($newBookmarks['pages'])
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to migrate bookmarks: ' . $e->getMessage()
            ], 500);
        }
    }
}