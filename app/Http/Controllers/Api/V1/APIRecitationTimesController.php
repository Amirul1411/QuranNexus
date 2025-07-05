<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class APIRecitationTimesController extends Controller
{
    public function updateRecitationTimes(Request $request)
    {
        try {
            $request->validate([
                'duration_seconds' => 'required|integer|min:60'
            ]);

            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            // Calculate recitation times (1 time per minute)
            $times = ceil($request->duration_seconds / 60);
            
            // Get today's date as key
            $today = Carbon::now()->format('Y-m-d');

            // Get current recitation times
            $recitationTimes = $user->recitation_times ?? [];
            
            // Update today's count
            $recitationTimes[$today] = ($recitationTimes[$today] ?? 0) + $times;
            
            // Update the entire recitation_times field
            $user->recitation_times = $recitationTimes;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Recitation times updated successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update recitation times: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRecitationTimes()
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
                'recitation_times' => $user->recitation_times ?? []
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get recitation times: ' . $e->getMessage()
            ], 500);
        }
    }
}