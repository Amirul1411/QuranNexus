<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Word;
use MongoDB\BSON\ObjectId;
use App\Models\WordStatistic;
use Illuminate\Support\Facades\Log;
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
                    $isDuplicate = collect($user->bookmarks['chapters'] ?? [])->contains(function ($item) use ($request) {
                        return $item['item_properties']['chapter_id'] === $request->item_properties['chapter_id'];
                    });
                    break;
                case 'verse':
                    $isDuplicate = collect($user->bookmarks['verses'] ?? [])->contains(function ($item) use ($request) {
                        // Check against the global ayah_index
                        if (!isset($item['item_properties']['ayah_index'])) {
                            return false;
                        }
                        return $item['item_properties']['ayah_index'] === $request->item_properties['ayah_index'];
                    });
                    break;
                case 'word':
                  // Duplicate check remains based on word_text
                    $isDuplicate = collect($user->bookmarks['words'] ?? [])->contains(function ($item) use ($request) {
                        return isset($item['item_properties']['word_text']) && $item['item_properties']['word_text'] === $request->item_properties['word_text'];
                    });

                    if (!$isDuplicate) {
                        // Find word_statistics_id based on word_text
                        // Assuming you have a WordStatistic model mapped to your 'word_statistics' MongoDB collection
                        $wordStatistic = WordStatistic::where('word', $request->item_properties['word_text'])->first();
                        
                        if ($wordStatistic) {
                            // Reconstruct item_properties to match the new desired structure
                            $newItemProperties = [
                                'word_statistics_id' => (string) $wordStatistic->_id, // Cast ObjectId to string
                                'word_text' => $request->item_properties['word_text'],
                                'translation' => $request->item_properties['translation'] ?? ($wordStatistic->translation ?? 'N/A'),
                                'transliteration' => $request->item_properties['transliteration'] ?? ($wordStatistic->transliteration ?? 'N/A'),
                                'total_occurrences' => $request->item_properties['total_occurrences'] ?? ($wordStatistic->total_occurrences ?? 0),
                            ];
                        } else {
                            // Word not found in statistics, handle this case
                            // Option 1: Don't add the bookmark and return an error
                            // Option 2: Add bookmark with null/default word_statistics_id and data sent by client
                            Log::warning("WordStatistic not found for word_text: " . $request->item_properties['word_text']);
                            // For now, let's proceed with client data if stat not found, but without ID
                            //  $newItemProperties = [
                            //     'word_statistics_id' => null, // Or some placeholder
                            //     'word_text' => $request->item_properties['word_text'],
                            //     'translation' => $request->item_properties['translation'] ?? 'N/A',
                            //     'transliteration' => $request->item_properties['transliteration'] ?? 'N/A',
                            //     'total_occurrences' => $request->item_properties['total_occurrences'] ?? 0,
                            // ];
                            // Or you might choose to return an error:
                            return response()->json(['status' => 'error', 'message' => 'Word details not found in statistics for: ' . $request->item_properties['word_text']], 404);
                        }
                    }
                    break;
                case 'quote':
                    $isDuplicate = collect($user->bookmarks['quotes'] ?? [])->contains(function ($item) use ($request) {
                        return $item['item_properties']['quote_id'] === $request->item_properties['quote_id'];
                    });
                    break;
                case 'page':
                    $isDuplicate = collect($user->bookmarks['pages'] ?? [])->contains(function ($item) use ($request) {
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
    
            // Filter bookmarks and cast IDs to string
            $updatedBookmarks = $bookmarks->filter(function ($bookmark) use ($type, $itemId) {
                $itemId = (string) $itemId; // Ensure string comparison
                switch ($type) {
                    case 'chapter':
                        return (string) $bookmark['item_properties']['chapter_id'] !== $itemId;
                    case 'verse':
                        if (!isset($bookmark['item_properties']['ayah_index'])) {
                            return true; // Keep malformed bookmarks
                        }
                        return (string) $bookmark['item_properties']['ayah_index'] !== $itemId;
                    case 'word':
                        return (string) $bookmark['item_properties']['word_text'] !== $itemId;
                    case 'quote':
                        return (string) $bookmark['item_properties']['quote_id'] !== $itemId;
                    case 'page':
                        return (string) $bookmark['item_properties']['page_id'] !== $itemId;
                    default:
                        return true;
                }
            })->values()->all();
    
            // Ensure bookmarks are updated correctly
            $user->bookmarks = array_merge($user->bookmarks, [$bookmarkType => $updatedBookmarks]);
            $user->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Bookmark removed successfully'
            ], 200);
    
        } catch (\Exception $e) {
            \Log::error('Remove Bookmark Error: ' . $e->getMessage());
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

            // 1. Define the complete, ideal structure with empty arrays.
            $defaultBookmarks = [
                'chapters' => [],
                'verses' => [],
                'words' => [],
                'quotes' => [],
                'pages' => []
            ];

            // 2. Get the user's bookmarks, or an empty array if they have none at all.
            $userBookmarks = $user->bookmarks ?? [];

            // 3. Merge the user's bookmarks over the defaults.
            // This guarantees that if a key like 'verses' is missing from the user's data,
            // it will be present in the final result as an empty array.
            $bookmarks = array_merge($defaultBookmarks, $userBookmarks);

            return response()->json([
                'status' => 'success',
                'user_id' => $user->_id,
                'bookmarks' => $bookmarks // This is now guaranteed to be a complete object
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