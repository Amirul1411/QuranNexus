<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class APIRecitationStreakController extends Controller
{
    public function getRecitationStreak()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }
    
            // Initialize both flat and structured data if they don't exist
            if (!isset($user->recitation_streak)) {
                $user->recitation_streak = 0;
            }
            
            if (!isset($user->last_recitation_date)) {
                $user->last_recitation_date = null;
            }
    
            // Get current recitation times
            $recitationTimes = $user->recitation_times ?? [];
    
            // Calculate streak data with recitation times
            $streakData = $this->calculateStreakData($recitationTimes);
            
            // Calculate new consistency metrics
            $consistencyMetrics = $this->calculateConsistencyMetric($recitationTimes);
            
            // Add the new metrics to the streak data
            $streakData['consistency_metrics'] = $consistencyMetrics;
            
            // Update the streak data in the database
            $user->streak_data = $streakData;
            $user->save();
    
            return response()->json([
                'status' => 'success',
                'recitation_streak' => $user->recitation_streak,
                'last_recitation_date' => $user->last_recitation_date,
                'streak_data' => $streakData
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get recitation streak: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateRecitationStreak(Request $request)
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

            $today = Carbon::now();
            $lastDate = $user->last_recitation_date ? 
                Carbon::parse($user->last_recitation_date) : null;

            // Get or initialize streak data
            $streakData = $user->streak_data ?? [
                'current_streak' => 0,
                'longest_streak' => 0,
                'last_recitation_date' => null,
                'streak_start_date' => null,
                'streaks_history' => [],
                'total_days_recited' => 0,
                'consistency_score' => 0
            ];

            // Update streak logic
            if (!$lastDate || $today->diffInDays($lastDate) > 1) {
                // Record previous streak in history if it was significant
                if ($streakData['current_streak'] >= 3) {
                    $streakData['streaks_history'][] = [
                        'start_date' => $streakData['streak_start_date'],
                        'end_date' => $streakData['last_recitation_date'],
                        'length' => $streakData['current_streak']
                    ];
                }
                // Reset streak
                $streakData['current_streak'] = 1;
                $user->recitation_streak = 1;
                $streakData['streak_start_date'] = $today->format('Y-m-d');
            } elseif ($today->diffInDays($lastDate) == 1 || $today->isSameDay($lastDate)) {
                // Continue streak only if it's the next day or same day
                if (!$today->isSameDay($lastDate)) {
                    $streakData['current_streak']++;
                    $user->recitation_streak++;
                }
            }

            // Update longest streak if current is higher
            if ($streakData['current_streak'] > ($streakData['longest_streak'] ?? 0)) {
                $streakData['longest_streak'] = $streakData['current_streak'];
            }

            // Update last recitation date (both places)
            $todayStr = $today->format('Y-m-d');
            $streakData['last_recitation_date'] = $todayStr;
            $user->last_recitation_date = $todayStr;

            // Update recitation times
            $recitationTimes = $user->recitation_times ?? [];
            $minutesToday = isset($recitationTimes[$todayStr]) ? 
                $recitationTimes[$todayStr] : 0;
            
            // Add new minutes (convert seconds to minutes)
            $additionalMinutes = ceil($request->duration_seconds / 60);
            $recitationTimes[$todayStr] = $minutesToday + $additionalMinutes;
            
            // Save recitation times
            $user->recitation_times = $recitationTimes;
            $streakData['recitation_times'] = $recitationTimes;

            // Update total days recited (only if it's a new day)
            if (!$lastDate || !$today->isSameDay($lastDate)) {
                $streakData['total_days_recited'] = ($streakData['total_days_recited'] ?? 0) + 1;
            }

            // Calculate new consistency metrics
            $consistencyMetrics = $this->calculateConsistencyMetric($recitationTimes);
            $streakData['consistency_metrics'] = $consistencyMetrics;
            
            // Calculate consistency score
            $streakData['consistency_score'] = $this->calculateConsistencyScore($recitationTimes);

            // Save all updates
            $user->streak_data = $streakData;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Recitation streak updated successfully',
                'recitation_streak' => $user->recitation_streak,
                'last_recitation_date' => $user->last_recitation_date,
                'streak_data' => $streakData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update recitation streak: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Migrate and standardize recitation streak data
     */
    public function migrateRecitationData()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            // 1. Get the recitation_times data from both sources
            $recitationTimes = $user->recitation_times ?? [];
            $nestedRecitationTimes = $user->streak_data['recitation_times'] ?? [];
            
            // 2. Merge both sources (outer data takes precedence)
            $combinedRecitationTimes = array_merge($nestedRecitationTimes, $recitationTimes);
            
            // 3. Standardize all dates to use 2025 year
            $standardizedRecitationTimes = [];
            foreach ($combinedRecitationTimes as $dateStr => $minutes) {
                $date = Carbon::parse($dateStr);
                
                // Convert all dates to 2025 (keeping month and day)
                $newDate = Carbon::create(2025, $date->month, $date->day);
                $standardizedRecitationTimes[$newDate->format('Y-m-d')] = $minutes;
            }
            
            // 4. Calculate streak data with the standardized times
            $streakData = $this->calculateStreakData($standardizedRecitationTimes);
            
            // 5. Calculate consistency metrics
            $consistencyMetrics = $this->calculateConsistencyMetric($standardizedRecitationTimes);
            $streakData['consistency_metrics'] = $consistencyMetrics;
            
            // 6. Update both the nested and outer data
            $user->recitation_times = $standardizedRecitationTimes;
            $user->streak_data = $streakData;
            $user->recitation_streak = $streakData['current_streak'];
            $user->last_recitation_date = $streakData['last_recitation_date'];
            
            // 7. Save the updated user data
            $user->save();
            
            // 8. Return success response with the updated data
            return response()->json([
                'status' => 'success',
                'message' => 'Recitation streak data migrated and standardized successfully',
                'recitation_streak' => $user->recitation_streak,
                'last_recitation_date' => $user->last_recitation_date,
                'recitation_times_count' => count($standardizedRecitationTimes),
                'streak_data' => $streakData
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to migrate recitation streak data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calculate consistency score (percentage of days in the last 30 days)
     */
    private function calculateConsistencyScore($recitationTimes)
    {
        $today = Carbon::now()->startOfDay();
        $thirtyDaysAgo = $today->copy()->subDays(30)->format('Y-m-d');
        $daysRecitedLast30 = 0;
        
        foreach (array_keys($recitationTimes) as $date) {
            if ($date >= $thirtyDaysAgo) {
                $daysRecitedLast30++;
            }
        }
        
        return min(100, round(($daysRecitedLast30 / 30) * 100));
    }
    
    /**
     * Calculate consistency metrics that are more meaningful than a percentage
     */
    private function calculateConsistencyMetric($recitationTimes)
    {
        // Get the dates from the last 30 days
        $today = Carbon::now()->startOfDay();
        $thirtyDaysAgo = $today->copy()->subDays(29); // 30 days including today
        
        // Track active days in the last 30 days
        $daysRecited = 0;
        
        // Create a map of dates with activity
        $activeDays = [];
        foreach ($recitationTimes as $dateStr => $minutes) {
            $date = Carbon::parse($dateStr);
            if ($date->greaterThanOrEqualTo($thirtyDaysAgo) && $date->lessThanOrEqualTo($today)) {
                $activeDays[$dateStr] = true;
                $daysRecited++;
            }
        }
        
        // Calculate frequency score (days per week on average)
        $weeksInPeriod = 30 / 7; // ~4.28 weeks in 30 days
        $averageDaysPerWeek = round($daysRecited / $weeksInPeriod, 1);
        
        // Calculate regularity score (how evenly distributed the recitations are)
        $regularity = $this->calculateRegularityScore($activeDays, $thirtyDaysAgo, $today);
        
        // Return metrics
        return [
            'days_recited' => $daysRecited,
            'total_days' => 30,
            'days_per_week' => $averageDaysPerWeek,
            'regularity' => $regularity,
            'consistency_label' => $this->getConsistencyLabel($daysRecited, $averageDaysPerWeek, $regularity)
        ];
    }

    /**
     * Calculate a regularity score based on how evenly spaced recitation days are
     */
    private function calculateRegularityScore($activeDays, $startDate, $endDate)
    {
        if (count($activeDays) <= 1) {
            return 0.0; // Not enough data for regularity calculation
        }
        
        // Sort the active days
        $dates = array_keys($activeDays);
        sort($dates);
        
        // Calculate gaps between consecutive sessions
        $gaps = [];
        for ($i = 1; $i < count($dates); $i++) {
            $current = Carbon::parse($dates[$i]);
            $previous = Carbon::parse($dates[$i-1]);
            $gaps[] = $current->diffInDays($previous);
        }
        
        // Calculate variance of gaps
        if (empty($gaps)) {
            return 0.0;
        }
        
        $average = array_sum($gaps) / count($gaps);
        $variance = 0;
        
        foreach ($gaps as $gap) {
            $variance += pow($gap - $average, 2);
        }
        
        $variance = $variance / count($gaps);
        
        // Convert variance to a 0-1 score (lower variance = higher regularity)
        $regularity = 1 / (1 + sqrt($variance));
        
        return round($regularity, 2);
    }

    /**
     * Generate a consistency label based on metrics
     */
    private function getConsistencyLabel($daysRecited, $daysPerWeek, $regularity)
    {
        // Based on frequency (days per week)
        if ($daysPerWeek >= 5) {
            $frequencyLabel = "Very frequent";
        } elseif ($daysPerWeek >= 3) {
            $frequencyLabel = "Regular";
        } elseif ($daysPerWeek >= 1) {
            $frequencyLabel = "Occasional";
        } else {
            $frequencyLabel = "Infrequent";
        }
        
        // Based on regularity
        if ($regularity >= 0.8) {
            $regularityLabel = "very consistent";
        } elseif ($regularity >= 0.5) {
            $regularityLabel = "somewhat consistent";
        } else {
            $regularityLabel = "variable";
        }
        
        // Combine for final label
        return "$frequencyLabel ($regularityLabel)";
    }
    
    /**
     * Calculate streak data from recitation times
     */
    private function calculateStreakData($recitationTimes)
    {
        // Sort dates chronologically (oldest to newest)
        ksort($recitationTimes);
        $dates = array_keys($recitationTimes);
        
        if (empty($dates)) {
            return [
                'current_streak' => 0,
                'longest_streak' => 0,
                'last_recitation_date' => null,
                'streak_start_date' => null,
                'streaks_history' => [],
                'total_days_recited' => 0,
                'consistency_score' => 0,
                'recitation_times' => []
            ];
        }
        
        // Get today and yesterday for streak check
        $today = Carbon::now()->startOfDay();
        $yesterday = $today->copy()->subDay();
        
        // Initialize variables for streak tracking
        $streaks = [];
        $currentStreak = 1;
        $streakStartDate = $dates[0];
        $lastDate = Carbon::parse($dates[0]);
        
        // Find all streaks by checking consecutive days
        for ($i = 1; $i < count($dates); $i++) {
            $currentDate = Carbon::parse($dates[$i]);
            $daysBetween = $currentDate->diffInDays($lastDate);
            
            if ($daysBetween == 1) {
                // Consecutive day, continue current streak
                $currentStreak++;
            } else {
                // Gap found, record completed streak and start a new one
                $streaks[] = [
                    'start' => $streakStartDate,
                    'end' => $dates[$i-1],
                    'length' => $currentStreak
                ];
                $currentStreak = 1;
                $streakStartDate = $dates[$i];
            }
            
            $lastDate = $currentDate;
        }
        
        // Add the final streak to our collection
        $streaks[] = [
            'start' => $streakStartDate,
            'end' => end($dates),
            'length' => $currentStreak
        ];
        
        // Sort streaks by length (longest first)
        usort($streaks, function($a, $b) {
            return $b['length'] - $a['length'];
        });
        
        // Determine if current streak is still active
        $lastRecitationDate = Carbon::parse(end($dates));
        $isCurrentStreakActive = $lastRecitationDate->isSameDay($today) || 
                                $lastRecitationDate->isSameDay($yesterday);
        
        // Find active streak (either the last one if still active, or 0)
        $activeStreak = $isCurrentStreakActive ? $streaks[count($streaks) - 1]['length'] : 0;
        
        // Find longest streak
        $longestStreak = !empty($streaks) ? $streaks[0]['length'] : 0;
        
        // Format streak history (for streaks 3+ days)
        $streakHistory = [];
        foreach ($streaks as $streak) {
            if ($streak['length'] >= 3) {
                $streakHistory[] = [
                    'start_date' => $streak['start'],
                    'end_date' => $streak['end'],
                    'length' => $streak['length']
                ];
            }
        }
        
        // Calculate consistency score (% of days in the last 30 days with recitation)
        $thirtyDaysAgo = $today->copy()->subDays(30)->format('Y-m-d');
        $daysRecitedLast30 = 0;
        
        foreach ($dates as $date) {
            if ($date >= $thirtyDaysAgo) {
                $daysRecitedLast30++;
            }
        }
        
        $consistencyScore = min(100, round(($daysRecitedLast30 / 30) * 100));
        
        // Get current streak start date if active
        $currentStreakStart = $isCurrentStreakActive ? $streaks[count($streaks) - 1]['start'] : null;
        
        return [
            'current_streak' => $activeStreak,
            'longest_streak' => $longestStreak,
            'last_recitation_date' => end($dates),
            'streak_start_date' => $currentStreakStart,
            'streaks_history' => $streakHistory,
            'total_days_recited' => count($dates),
            'consistency_score' => $consistencyScore,
            'recitation_times' => $recitationTimes
        ];
    }
}