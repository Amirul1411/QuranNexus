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

class User extends Authenticatable implements FilamentUser
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
    protected $fillable = ['_id', 'name', 'email', 'password', 'role', 'recitation_times', 'recitation_streak', 'last_recitation_date'];

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

    public function addBookmark($type, $itemId)
    {
        if ($type === 'surah') {
            $this->push('surah_bookmarks', $itemId);
        } elseif ($type === 'page') {
            $this->push('page_bookmarks', $itemId);
        } elseif ($type === 'ayah') {
            $this->push('ayah_bookmarks', $itemId);
        }
    }

    public function removeBookmark($type, $itemId)
    {
        if ($type === 'surah') {
            $this->pull('surah_bookmarks', $itemId);
        } elseif ($type === 'page') {
            $this->pull('page_bookmarks', $itemId);
        } elseif ($type === 'ayah') {
            $this->pull('ayah_bookmarks', $itemId);
        }
    }

    public function isBookmarked($type, $itemId)
    {
        if ($type === 'surah') {
            return in_array($itemId, $this->surah_bookmarks ?? []);
        } elseif ($type === 'page') {
            return in_array($itemId, $this->page_bookmarks ?? []);
        } elseif ($type === 'ayah') {
            return in_array($itemId, $this->ayah_bookmarks ?? []);
        }

        return false;
    }

    public function markAsRecentlyRead($type, $itemId)
    {
        $timestamp = now()->toDateTimeString(); // Use start of the day for clearing by day

        if ($type === 'surah') {
            $this->pull('recently_read_surahs', ['item_id' => $itemId]);
            $this->push('recently_read_surahs', ['item_id' => $itemId, 'read_at' => $timestamp]);
        } elseif ($type === 'page') {
            $this->pull('recently_read_pages', ['item_id' => $itemId]);
            $this->push('recently_read_pages', ['item_id' => $itemId, 'read_at' => $timestamp]);
        } elseif ($type === 'juz') {
            $this->pull('recently_read_juzs', ['item_id' => $itemId]);
            $this->push('recently_read_juzs', ['item_id' => $itemId, 'read_at' => $timestamp]);
        }
    }

    public function cleanOldRecentlyReadItems($type)
    {
        $currentMinute = now();

        if ($type === 'surah' && !empty($this->recently_read_surahs)) {
            $this->recently_read_surahs = collect($this->recently_read_surahs)
                ->filter(function ($item) use ($currentMinute) {
                    return Carbon::parse($item['read_at'])->greaterThan($currentMinute->subDays(1));
                })
                ->toArray();
            $this->save();
        } elseif ($type === 'page' && !empty($this->recently_read_pages)) {
            $this->recently_read_pages = collect($this->recently_read_pages)
                ->filter(function ($item) use ($currentMinute) {
                    return Carbon::parse($item['read_at'])->greaterThan($currentMinute->subDays(1));
                })
                ->toArray();
            $this->save();
        } elseif ($type === 'juz' && !empty($this->recently_read_juzs)) {
            $this->recently_read_juzs = collect($this->recently_read_juzs)
                ->filter(function ($item) use ($currentMinute) {
                    return Carbon::parse($item['read_at'])->greaterThan($currentMinute->subDays(1));
                })
                ->toArray();
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

        if (!isset($this->attributes['streak'])) {
            $this->attributes['streak'] = 0;
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
                $this->attributes['streak'] += 1;
            } elseif($this->attributes['last_recitation_date'] === $today) {
                // Maintain the streak
                $this->attributes['streak'] = $this->attributes['streak'];
            } else {
                // Reset streak to 1 if recitation was missed the previous day
                $this->attributes['streak'] = 1;
            }

            // Update last recitation date
            $this->attributes['last_recitation_date'] = $today;
        }

        // Save the updated recitation_times, streak, and last_recitation_date fields in MongoDB
        $this->update([
            'recitation_times' => $this->attributes['recitation_times'],
            'streak' => $this->attributes['streak'],
            'last_recitation_date' => $this->attributes['last_recitation_date'],
        ]);
    }
}
