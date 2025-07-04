<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class APIRecentlyReadController extends Controller
{
    public function getRecentlyRead(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            // Initialize structure if doesn't exist
            $recentlyRead = $user->recently_read ?? [
                'chapters' => [],
                'pages' => [],
                'juzs' => []
            ];

            // If type filter is provided
            $type = $request->query('type');
            if ($type && in_array($type, ['chapters', 'pages', 'juzs'])) {
                $recentlyRead = [
                    $type => $recentlyRead[$type]
                ];
            }

            return response()->json([
                'status' => 'success',
                'recently_read' => $recentlyRead
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch recently read: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addRecentlyRead(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|string|in:chapter,page,juz',
                'item_id' => 'required|string',
                'duration_seconds' => 'required|integer|min:60'
            ]);
    
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }
    
            $type = $request->type.'s'; // Convert to plural
            
            // Create new entry with current time
            $newItem = [
                'item_id' => (string) $request->item_id,
                'read_at' => (string) Carbon::now()->toDateTimeString()
            ];
    
            // Get the full recently read data
            $recentlyRead = $user->recently_read ?? [
                'chapters' => [],
                'pages' => [],
                'juzs' => []
            ];
            
            // Get current items for the specific type
            $currentItems = $recentlyRead[$type] ?? [];
            
            // Remove existing entry if present
            $currentItems = collect($currentItems)
                ->filter(function($item) use($request) {
                    return $item['item_id'] !== (string) $request->item_id;
                })
                ->values()
                ->all();
    
            // Add new item at the beginning
            array_unshift($currentItems, $newItem);
            
            // Keep only the last 5 items
            $currentItems = array_slice($currentItems, 0, 5);
            
            // Update the specific type in the recently_read array
            $recentlyRead[$type] = $currentItems;
            
            // Update the entire recently_read field
            $user->recently_read = $recentlyRead;
            $user->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Recently read item added successfully'
            ], 201);
    
        } catch (\Exception $e) {
            \Log::error('Failed to add recently read', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add recently read: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeRecentlyRead(Request $request, $type, $itemId)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            // Convert type to plural
            $typePlural = $type.'s';
            
            // Get the full recently read data
            $recentlyRead = $user->recently_read ?? [
                'chapters' => [],
                'pages' => [],
                'juzs' => []
            ];

            if (!isset($recentlyRead[$typePlural])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid type'
                ], 400);
            }

            // Filter out the item to remove
            $recentlyRead[$typePlural] = collect($recentlyRead[$typePlural])
                ->filter(function($item) use($itemId) {
                    return $item['item_id'] !== $itemId;
                })
                ->values()
                ->all();

            // Update the entire recently_read field
            $user->recently_read = $recentlyRead;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Recently read item removed successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove recently read: ' . $e->getMessage()
            ], 500);
        }
    }
}