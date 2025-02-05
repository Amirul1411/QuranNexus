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
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    // use TwoFactorAuthenticatable;

    protected $connection = 'mongodb';
    protected $collection = 'users';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Get the class name for the personal access token model.
     *
     * @return string
     */
    public function newAccessToken($name, array $abilities = ['*'])
    {
        return new PersonalAccessToken([
            'tokenable_type' => static::class,
            'tokenable_id' => $this->_id,
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
        ]);
    }

    public function currentAccessToken()
    {
        return $this->accessToken;
    }

    public static function findById($id)
    {
        Log::info('Finding user by ID', ['id' => $id]);
        return static::where('_id', $id)->first();
    }
    
    public function tokens()
    {
        return $this->morphMany(
            PersonalAccessToken::class,
            'tokenable',
            'tokenable_type',
            'tokenable_id'
        );
    }
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_EDITOR = 'EDITOR';
    const ROLE_USER = 'USER';
    const ROLE_DEFAULT = self::ROLE_USER;

    const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_EDITOR => 'Editor',
        self::ROLE_USER => 'User',
    ];
    public function createToken(string $name, array $abilities = ['*'])
    {
        $plainTextToken = Str::random(40);
        $hashedToken = hash('sha256', $plainTextToken);
        
        Log::info('Creating new token', [
            'plain_length' => strlen($plainTextToken),
            'hash_length' => strlen($hashedToken)
        ]);
    
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => $hashedToken,
            'abilities' => $abilities,
            'tokenable_type' => static::class,
            'tokenable_id' => $this->_id
        ]);
    
        Log::info('Token created', [
            'token_id' => $token->_id,
            'user_id' => $this->_id,
            'stored_hash_length' => strlen($token->token)
        ]);
    
        // Create the full token string
        $fullToken = $token->_id . '|' . $plainTextToken;
        
        Log::info('Full token created', [
            'full_token_length' => strlen($fullToken)
        ]);
    
        return new \Laravel\Sanctum\NewAccessToken(
            $token, 
            $fullToken
        );
    }
   
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
    protected $fillable = ['_id', 'name', 'email', 'password', 'role', 'recitation_times', 'recitation_streak', 'last_recitation_date', 'settings', 'recitation_goal', 'quiz_progress', 'word_bookmarks', 'quote_bookmarks' ];

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
                    return Carbon::parse($item['read_at'])->greaterThan($currentMinute->subHour());
                })
                ->values()
                ->toArray();
            $this->save();
        } elseif ($type === 'page' && !empty($this->recently_read_pages)) {
            $this->recently_read_pages = collect($this->recently_read_pages)
                ->filter(function ($item) use ($currentMinute) {
                    return Carbon::parse($item['read_at'])->greaterThan($currentMinute->subHour());
                })
                ->values()
                ->toArray();
            $this->save();
        } elseif ($type === 'juz' && !empty($this->recently_read_juzs)) {
            $this->recently_read_juzs = collect($this->recently_read_juzs)
                ->filter(function ($item) use ($currentMinute) {
                    return Carbon::parse($item['read_at'])->greaterThan($currentMinute->subHour());
                })
                ->values()
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
        }

        // Save the updated recitation_times, streak, and last_recitation_date fields in MongoDB
        $this->update([
            'recitation_times' => $this->attributes['recitation_times'],
            'recitation_streak' => $this->attributes['recitation_streak'],
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
    public function updateQuizProgress($surahId, $data)
    {
        $quizProgress = $this->quiz_progress ?? [];
        
        // Find existing quiz progress for this surah
        $index = collect($quizProgress)->search(function ($item) use ($surahId) {
            return $item['surah_id'] === $surahId;
        });

        // Ensure datetime fields are properly formatted
        if (isset($data['start_time'])) {
            $data['start_time'] = Carbon::now()->toDateTimeString();
        }
        if (isset($data['end_time']) && $data['end_time'] !== null) {
            $data['end_time'] = Carbon::now()->toDateTimeString();
        }
        
        if ($index !== false) {
            $quizProgress[$index] = array_merge($quizProgress[$index], $data);
        } else {
            $quizProgress[] = $data;
        }
        
        $this->quiz_progress = $quizProgress;
        $this->save();
        
        return $this->fresh();
    }
}
