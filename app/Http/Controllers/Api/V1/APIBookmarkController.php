<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use MongoDB\BSON\ObjectId;

class APIBookmarkController extends Controller
{
    public function addBookmark(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|string|in:chapter,verse',
                'item_id' => 'required|string',
            ]);

            // Get authenticated user
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            if ($request->type === 'chapter') {
                // Check if chapter already bookmarked
                if (in_array($request->item_id, $user->surah_bookmarks ?? [])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Chapter already bookmarked'
                    ], 409);
                }

                // Add to surah_bookmarks array
                $user->push('surah_bookmarks', $request->item_id);

            } else if ($request->type === 'verse') {
                // Check if verse already bookmarked
                if (in_array($request->item_id, $user->ayah_bookmarks ?? [])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Verse already bookmarked'
                    ], 409);
                }

                // Add to regular ayah_bookmarks
                $user->push('ayah_bookmarks', $request->item_id);

                // Add to mobile bookmarks with additional info
                $mobileBookmark = [
                    'ayah_id' => $request->item_id,
                    'chapter_id' => $request->chapter_id,
                    'notes' => $request->notes ?? '',
                    'created_at' => now()->toDateTimeString()
                ];

                $user->push('ayah_bookmarks_mobile', $mobileBookmark);
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

            if ($type === 'chapter') {
                $user->pull('surah_bookmarks', $itemId);
            } else if ($type === 'verse') {
                $user->pull('ayah_bookmarks', $itemId);
                // Remove from mobile bookmarks
                $user->pull('ayah_bookmarks_mobile', ['ayah_id' => $itemId]);
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
                    'verses' => $user->ayah_bookmarks_mobile ?? []
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch bookmarks: ' . $e->getMessage()
            ], 500);
        }
    }
}