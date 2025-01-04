<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

class APIBookmarkController extends Controller
{
    public function addBookmark(Request $request, $userId)
    {
        $request->validate([
            'type' => 'required|string|in:chapter,verse,word,daily_quote',
            'item_id' => 'required|string',
        ]);

        // Check if bookmark already exists
        $existingBookmark = app('db')->collection('bookmarks')->findOne([
            'user_id' => $userId,
            'type' => $request->type,
            'item_id' => $request->item_id,
        ]);

        if ($existingBookmark) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bookmark already exists'
            ], 409);
        }

        $bookmark = [
            'type' => $request->type,
            'item_id' => $request->item_id,
            'user_id' => $userId,
            'created_at' => now()->toDateTimeString(),
        ];

        $result = app('db')->collection('bookmarks')->insertOne($bookmark);

        return response()->json([
            'status' => 'success',
            'bookmark_id' => (string)$result->getInsertedId(),
            'bookmark' => $bookmark
        ], 201);
    }

    public function removeBookmark($userId, $bookmarkId)
    {
        try {
            $deleteResult = app('db')->collection('bookmarks')->deleteOne([
                '_id' => new ObjectId($bookmarkId),
                'user_id' => $userId
            ]);

            if ($deleteResult->getDeletedCount() > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Bookmark deleted successfully'
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Bookmark not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete bookmark',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBookmarks($userId)
    {
        try {
            // Get the bookmarks collection
            $collection = app('db')->collection('bookmarks');
            
            // Execute the find query and get the cursor
            $cursor = $collection->find(['user_id' => $userId]);
            
            if (!$cursor) {
                return response()->json([
                    'status' => 'success',
                    'user_id' => $userId,
                    'bookmarks' => []
                ], 200);
            }

            // Convert cursor to array
            $bookmarks = iterator_to_array($cursor) ?? [];

        $formattedBookmarks = [];
        foreach ($bookmarks as $bookmark) {
            switch ($bookmark['type']) {
                case 'chapter':
                    $formattedBookmarks[] = $this->formatChapterBookmark($bookmark);
                    break;
                case 'verse':
                    $formattedBookmarks[] = $this->formatVerseBookmark($bookmark);
                    break;
                case 'word':
                    $formattedBookmarks[] = $this->formatWordBookmark($bookmark);
                    break;
                case 'daily_quote':
                    $formattedBookmarks[] = $this->formatDailyQuoteBookmark($bookmark);
                    break;
            }
        }

            return response()->json([
                'status' => 'success',
                'user_id' => $userId,
                'bookmarks' => $formattedBookmarks
            ], 200);
        }
    }

    private function formatChapterBookmark($bookmark)
    {
        $chapter = app('db')->collection('chapters')->findOne(['_id' => $bookmark['item_id']]);
        return [
            '_id' => $chapter['_id'],
            'name' => $chapter['name'],
            'tname' => $chapter['tname'],
            'ename' => $chapter['ename'],
            'type' => $chapter['type'],
            'ayas' => $chapter['ayas'],
        ];
    }

    private function formatVerseBookmark($bookmark)
    {
        $verse = app('db')->collection('verses')->findOne(['_id' => $bookmark['item_id']]);
        return [
            '_id' => $verse['_id'],
            'page_id' => $verse['page_id'],
            'juz_id' => $verse['juz_id'],
            'surah_id' => $verse['surah_id'],
            'ayah_index' => $verse['ayah_index'],
            'ayah_key' => $verse['ayah_key'],
            'bismillah' => $verse['bismillah'],
            'text' => $verse['text'],
            'isVerified' => $verse['isVerified'],
        ];
    }

    private function formatWordBookmark($bookmark)
    {
        $word = app('db')->collection('words')->findOne(['_id' => $bookmark['item_id']]);
        return [
            '_id' => $word['_id'],
            'surah_id' => $word['surah_id'],
            'ayah_index' => $word['ayah_index'],
            'word_index' => $word['word_index'],
            'ayah_key' => $word['ayah_key'],
            'word_key' => $word['word_key'],
            'audio_url' => $word['audio_url'],
            'page_id' => $word['page_id'],
            'line_number' => $word['line_number'],
            'text' => $word['text'],
            'characters' => $word['characters'],
            'translation' => $word['translation'],
            'transliteration' => $word['transliteration'],
        ];
    }

    private function formatDailyQuoteBookmark($bookmark)
    {
        $quote = app('db')->collection('daily_quotes')->findOne(['_id' => $bookmark['item_id']]);
        return [
            'title' => $quote['title'],
            'description' => $quote['description'],
            'source' => $quote['source'],
        ];
    }
}
