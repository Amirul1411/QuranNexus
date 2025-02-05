<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;


class APIUserAchievementController extends Controller
{
    public function unlockAchievement(Request $request)
    {
        try {
            $request->validate([
                'achievement_id' => 'required|string'
            ]);

            $user = auth()->user();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated'], 401);
            }

            // Initialize achievements array if it doesn't exist
            if (!isset($user->achievements)) {
                $user->achievements = [];
            }

            // Add the achievement if not already present
            $achievementExists = false;
            foreach ($user->achievements as $achievement) {
                if ($achievement['id'] === $request->achievement_id) {
                    $achievementExists = true;
                    break;
                }
            }

            if (!$achievementExists) {
                $user->push('achievements', [
                    'id' => $request->achievement_id,
                    'unlock_date' => now()->toDateTimeString()
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Achievement unlocked successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to unlock achievement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAchievementStatus()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated'], 401);
            }

            $unlockedAchievements = collect($user->achievements ?? [])
                ->pluck('id')
                ->toArray();

            // Create a status map for all achievements
            $achievementStatus = [
                'longest_chapter' => [
                    'id' => 'longest_chapter',
                    'status' => in_array('longest_chapter', $unlockedAchievements) ? 'Completed' : 'Not Achieved',
                    'unlock_date' => $this->getUnlockDate($user->achievements, 'longest_chapter')
                ],
                'shortest_chapter' => [
                    'id' => 'shortest_chapter',
                    'status' => in_array('shortest_chapter', $unlockedAchievements) ? 'Completed' : 'Not Achieved',
                    'unlock_date' => $this->getUnlockDate($user->achievements, 'shortest_chapter')
                ],
                'weekly_streak' => [
                    'id' => 'weekly_streak',
                    'status' => in_array('weekly_streak', $unlockedAchievements) ? 'Completed' : 'Not Achieved',
                    'unlock_date' => $this->getUnlockDate($user->achievements, 'weekly_streak'),
                    'progress' => [
                        'current_streak' => $user->recitation_streak ?? 0,
                        'target_streak' => 7
                    ]
                ]
            ];

            return response()->json([
                'status' => 'success',
                'achievement_status' => $achievementStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch achievement status: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getUnlockDate($achievements, $achievementId)
    {
        if (!$achievements) return null;
        
        foreach ($achievements as $achievement) {
            if ($achievement['id'] === $achievementId) {
                return $achievement['unlock_date'] ?? null;
            }
        }
        return null;
    }

    public function checkStreakAchievement()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated'], 401);
            }

            $streak = $user->recitation_streak ?? 0;
            $isEligible = $streak >= 7;

            return response()->json([
                'status' => 'success',
                'is_eligible' => $isEligible,
                'current_streak' => $streak
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to check streak: ' . $e->getMessage()
            ], 500);
        }
    }
}