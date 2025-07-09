<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User; // Make sure to import your User model

class APIRecitationStatsController extends Controller
{
   /**
     * Get the user's current recitation statistics.
     * This endpoint is fast as it primarily returns pre-calculated data.
     */  public function getRecitationStats(Request $request)
    {
        try {
            $user = $request->user();
            $streakData = $user->streak_data ?? null;

            // Self-healing: If streak_data is missing, recalculate it.
            if (empty($streakData) && !empty($user->recitation_times)) {
                $streakData = $this->calculateAllStatsFromTimes($user->recitation_times);
                $user->streak_data = $streakData;
                $user->save();
            }

            // Ensure response structure is always consistent
            if (empty($streakData)) {
                $streakData = $this->getEmptyStreakData();
            }

            // Always include recitation_times for charts
            $streakData['recitation_times'] = $user->recitation_times ?? [];

            return response()->json([
                'status' => 'success',
                'streak_data' => $streakData
            ], 200);

        } catch (\Exception $e) {
            // ... error handling
        }
    }

    /**
     * Update recitation time and incrementally update all streak statistics.
     * This is the only endpoint the app should call to log new recitation.
     */
     public function updateRecitation(Request $request)
    {
        try {
            $request->validate([
                'duration_seconds' => 'required|integer|min:60'
            ]);

            $user = $request->user();
            $todayStr = Carbon::now()->format('Y-m-d');

            // --- 1. Get and update the source of truth ---
            $recitationTimes = $user->recitation_times ?? [];
            if (is_object($recitationTimes)) {
                $recitationTimes = (array) $recitationTimes;
            }
            $additionalMinutes = ceil($request->duration_seconds / 60);
            $recitationTimes[$todayStr] = ($recitationTimes[$todayStr] ?? 0) + $additionalMinutes;

            // --- 2. Calculate ALL stats from the updated source of truth ---
            $streakData = $this->calculateAllStatsFromTimes($recitationTimes);

            // --- 3. Save to the database ---
            $user->forceFill([
                'recitation_times' => $recitationTimes,
                'streak_data' => $streakData
            ]);
            $user->save();

            // --- 4. Return the complete data for the client ---
            $streakData['recitation_times'] = $recitationTimes;

            return response()->json([
                'status' => 'success',
                'message' => 'Recitation stats updated successfully',
                'streak_data' => $streakData
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Failed to update recitation stats: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update recitation stats: ' . $e->getMessage()
            ], 500);
        }
    }

    // --- Private Helper Functions ---

    private function getEmptyStreakData()
    {
        return [
            'current_streak' => 0,
            'longest_streak' => 0,
            'last_recitation_date' => null,
            'streak_start_date' => null,
            'total_days_recited' => 0,
            'consistency_score' => 0,
            'consistency_metrics' => [
                'days_recited' => 0,
                'total_days' => 30,
                'days_per_week' => 0.0,
            ]
        ];
    }

    private function calculateConsistencyScore(array $recitationTimes): int
    {
        $today = Carbon::now()->startOfDay();
        $thirtyDaysAgo = $today->copy()->subDays(29)->format('Y-m-d'); // 30 days including today
        $daysRecitedLast30 = 0;
        
        foreach (array_keys($recitationTimes) as $date) {
            if ($date >= $thirtyDaysAgo) {
                $daysRecitedLast30++;
            }
        }
        
        return $daysRecitedLast30 > 0 ? min(100, round(($daysRecitedLast30 / 30) * 100)) : 0;
    }

    private function calculateConsistencyMetric(array $recitationTimes): array
    {
        $today = Carbon::now()->startOfDay();
        $thirtyDaysAgo = $today->copy()->subDays(29);
        $daysRecited = 0;
        
        foreach (array_keys($recitationTimes) as $dateStr) {
            $date = Carbon::parse($dateStr);
            if ($date->between($thirtyDaysAgo, $today)) {
                $daysRecited++;
            }
        }
        
        $weeksInPeriod = 30 / 7;
        $averageDaysPerWeek = $weeksInPeriod > 0 ? round($daysRecited / $weeksInPeriod, 1) : 0;
        
        return [
            'days_recited' => $daysRecited,
            'total_days' => 30,
            'days_per_week' => $averageDaysPerWeek,
        ];
    }
    
    /**
     * A powerful function to rebuild all stats from scratch.
     * Useful for migrations, corrections, or self-healing.
     */
   private function calculateAllStatsFromTimes(array $recitationTimes): array
    {
        // Sort dates chronologically, which is essential.
        ksort($recitationTimes);
        $dates = array_keys($recitationTimes);

        if (empty($dates)) {
            return $this->getEmptyStreakData();
        }

        $longestStreak = 0;
        $currentStreak = 0;
        $activeStreak = 0;
        
        if (!empty($dates)) {
            $streakCount = 1;
            $longestStreak = 1;

            // --- SINGLE UNIFIED LOOP ---
            for ($i = 1; $i < count($dates); $i++) {
                $currentDate = Carbon::parse($dates[$i]);
                $previousDate = Carbon::parse($dates[$i-1]);

                // Use isSameDay() and addDay() for robust, timezone-safe comparison
                if ($currentDate->isSameDay($previousDate->copy()->addDay())) {
                    $streakCount++;
                } else {
                    // Streak is broken, reset the counter
                    $streakCount = 1;
                }

                // Update longest streak on every iteration
                if ($streakCount > $longestStreak) {
                    $longestStreak = $streakCount;
                }
            }
            // After the loop, $streakCount holds the value of the most recent streak.
            // This is our potential "current" streak.
            $currentStreak = $streakCount;

            // --- DETERMINE IF THE STREAK IS ACTIVE ---
            $lastRecitationDate = Carbon::parse(end($dates));
            $today = Carbon::now();
            
            // Check if the last recitation was today or yesterday.
            if ($lastRecitationDate->isSameDay($today) || $lastRecitationDate->isSameDay($today->copy()->subDay())) {
                $activeStreak = $currentStreak;
            } else {
                // The streak is broken because it wasn't today or yesterday.
                $activeStreak = 0;
            }
        }

        return [
            'current_streak' => $activeStreak,
            'longest_streak' => $longestStreak,
            'last_recitation_date' => end($dates),
            'total_days_recited' => count($dates),
            'consistency_score' => $this->calculateConsistencyScore($recitationTimes),
            'consistency_metrics' => $this->calculateConsistencyMetric($recitationTimes),
        ];
    }
}