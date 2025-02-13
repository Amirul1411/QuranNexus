<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    // use TwoFactorAuthenticatable;

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_EDITOR = 'EDITOR';
    const ROLE_USER = 'USER';
    const ROLE_DEFAULT = self::ROLE_USER;

    const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_EDITOR => 'Editor',
        self::ROLE_USER => 'User',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->can('view-admin', User::class);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEditor()
    {
        return $this->role === self::ROLE_EDITOR;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['_id', 'name', 'email', 'password', 'role', 'recitation_times', 'recitation_streak', 'longest_streak', 'last_recitation_date', 'settings', 'recitation_goal', 'bookmarks', 'recently_read'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['profile_photo_url'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function scopeId($query)
    // {
    //     return $query->count()+1;
    // }

    // Add settings accessor and mutator
    // public function getSettingsAttribute($value)
    // {
    //     return $value ?? [
    //         'translation_id' => null,
    //         'tafseer_id' => null,
    //         'audio_id' => null,
    //     ];
    // }

    public function setSettingsAttribute($value)
    {
        // Initialize currentSettings as an empty array if 'settings' is not set
        $currentSettings = isset($this->attributes['settings']) ? $this->attributes['settings'] : [];
        $currentRecitationGoal = isset($this->attributes['recitation_goal']) ? $this->attributes['recitation_goal'] : null;

        // Merge the new settings with the existing ones
        $this->attributes['settings'] = array_merge($currentSettings, $value);
        $this->attributes['recitation_goal'] = $currentRecitationGoal;
    }

    public function addBookmark($type, $itemProperties, $notes)
    {
        $timestamp = now()->toDateTimeString();

        // Retrieve existing recently_read data
        $bookmarks = $this->bookmarks ?? [];

        $typeCast = [
            'surah' => 'chapters',
            'ayah' => 'verses',
            'page' => 'pages',
        ];

        $bookmarks[$typeCast[$type]] = $bookmarks[$typeCast[$type]] ?? [];

        // Push the bookmark into the specific type array
        $bookmarks[$typeCast[$type]][] = [
            'item_properties' => $itemProperties,
            'notes' => $notes,
            'created_at' => $timestamp,
        ];

        // Assign back and save
        $this->bookmarks = $bookmarks;
        $this->save();
    }

    public function removeBookmark($type, $itemProperties)
    {
        $typeCast = [
            'surah' => 'chapters',
            'ayah' => 'verses',
            'page' => 'pages',
        ];

        if (!isset($typeCast[$type])) {
            throw new \InvalidArgumentException("Invalid type: $type");
        }

        // Retrieve bookmarks array to avoid "Indirect modification" error
        $bookmarks = $this->bookmarks ?? [];

        if (isset($bookmarks[$typeCast[$type]])) {
            // Filter out the matching item
            $bookmarks[$typeCast[$type]] = array_values(array_filter($bookmarks[$typeCast[$type]], fn($bookmark) => $bookmark['item_properties'] != $itemProperties));

            // If the array is empty, remove the key
            if (empty($bookmarks[$typeCast[$type]])) {
                unset($bookmarks[$typeCast[$type]]);
            }

            // Save back to the model
            $this->bookmarks = $bookmarks;
            $this->save();
        }
    }

    public function isBookmarked($type, $itemProperties)
    {
        $typeCast = [
            'surah' => 'chapters',
            'ayah' => 'verses',
            'page' => 'pages',
        ];

        // Check if the bookmarks array and the specific type array exist
        if (isset($this->bookmarks[$typeCast[$type]])) {
            // Loop through the bookmarks of the specific type
            foreach ($this->bookmarks[$typeCast[$type]] as $bookmark) {
                // Check if the item_properties match
                if ($bookmark['item_properties'] == $itemProperties) {
                    return true;
                }
            }
        }

        return false;
    }

    public function markAsRecentlyRead($type, $itemId)
    {
        $timestamp = now()->toDateTimeString(); // Capture the current timestamp

        // Map type to the corresponding array name
        $typeCast = [
            'surah' => 'chapters',
            'page' => 'pages',
            'juz' => 'juzs',
        ];

        // Validate the type
        if (!isset($typeCast[$type])) {
            throw new \InvalidArgumentException("Invalid type: $type");
        }

        $arrayName = $typeCast[$type];

        // Retrieve existing recently_read data
        $recentlyRead = $this->recently_read ?? [];

        // Initialize the specific type array if it doesn't exist
        $recentlyRead[$arrayName] = $recentlyRead[$arrayName] ?? [];

        // Remove existing entry for the same item (if any)
        $recentlyRead[$arrayName] = array_values(array_filter($recentlyRead[$arrayName], fn($item) => $item['item_id'] != $itemId));

        // Add the new entry
        $recentlyRead[$arrayName][] = [
            'item_id' => $itemId,
            'read_at' => $timestamp,
        ];

        // Assign back and save
        $this->recently_read = $recentlyRead;
        $this->save();
    }

    public function cleanOldRecentlyReadItems($type)
    {
        $currentMinute = now();

        $typeCast = [
            'surah' => 'chapters',
            'page' => 'pages',
            'juz' => 'juzs',
        ];

        if (!isset($typeCast[$type])) {
            throw new \InvalidArgumentException("Invalid type: $type");
        }

        // Retrieve the recently_read attribute
        $recentlyRead = $this->recently_read ?? [];

        if (isset($recentlyRead[$typeCast[$type]])) {
            $recentlyRead[$typeCast[$type]] = array_values(array_filter($recentlyRead[$typeCast[$type]], fn($item) => Carbon::parse($item['read_at'])->greaterThan($currentMinute->subHour())));

            // If the array is empty, unset the key
            if (empty($recentlyRead[$typeCast[$type]])) {
                unset($recentlyRead[$typeCast[$type]]);
            }

            // Save back to the model
            $this->recently_read = $recentlyRead;
            $this->save();
        }
    }

    public function trackRecitationTime($minutes)
    {
        $today = now()->startOfDay()->toDateString(); // Use date string for consistency

        // Initialize recitation_times and streak if they don't exist
        if (!isset($this->attributes['recitation_times'])) {
            $this->attributes['recitation_times'] = [];
        }

        if (!isset($this->attributes['recitation_streak'])) {
            $this->attributes['recitation_streak'] = 0;
        }

        if (!isset($this->attributes['last_recitation_date'])) {
            $this->attributes['last_recitation_date'] = null;
        }

        // Get the current time spent today, or default to 0
        $timeSpentToday = $this->attributes['recitation_times'][$today] ?? 0;

        // Add the new session time to today's total
        $this->attributes['recitation_times'][$today] = $timeSpentToday + $minutes;

        // Check if at least 1 minute was spent on recitation today
        if ($this->attributes['recitation_times'][$today] >= 1) {
            $yesterday = now()->subDay()->startOfDay()->toDateString();

            // Check if recitation was done yesterday
            if ($this->attributes['last_recitation_date'] === $yesterday) {
                // Increment streak
                $this->attributes['recitation_streak'] += 1;
            } elseif ($this->attributes['last_recitation_date'] === $today) {
                // Maintain the streak
                $this->attributes['recitation_streak'] = $this->attributes['recitation_streak'];
            } else {
                // Reset streak to 1 if recitation was missed the previous day
                $this->attributes['recitation_streak'] = 1;
            }

            // Update last recitation date
            $this->attributes['last_recitation_date'] = $today;

            // Check if the current streak is the longest streak
            if (!isset($this->attributes['longest_streak']) || $this->attributes['recitation_streak'] > $this->attributes['longest_streak']) {
                $this->attributes['longest_streak'] = $this->attributes['recitation_streak'];
            }
        }

        // Save the updated recitation_times, streak, and last_recitation_date fields in MongoDB
        $this->update([
            'recitation_times' => $this->attributes['recitation_times'],
            'recitation_streak' => $this->attributes['recitation_streak'],
            'longest_streak' => $this->attributes['longest_streak'],
            'last_recitation_date' => $this->attributes['last_recitation_date'],
        ]);
    }

    public function resetRecitationStreak()
    {
        if (isset($this->attributes['recitation_streak']) && isset($this->attributes['last_recitation_date'])) {
            $today = now()->startOfDay()->toDateString();
            $yesterday = now()->subDay()->startOfDay()->toDateString();

            // Check if recitation was done today and yesterday
            if ($this->attributes['last_recitation_date'] !== $today && $this->attributes['last_recitation_date'] !== $yesterday) {
                // Reset streak to 0 if recitation was missed the previous day
                $this->attributes['recitation_streak'] = 0;
            }

            $this->update([
                'recitation_streak' => $this->attributes['recitation_streak'],
            ]);
        }
    }
}
