<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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
    // use HasProfilePhoto;
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

    public function isAdmin(){
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEditor(){
        return $this->role === self::ROLE_EDITOR;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        '_id',
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

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

    // Define relationships for bookmarks
    public function bookmarks()
    {
        return [
            'surah' => $this->belongsToMany(Surah::class, 'surah_bookmark')->withTimestamps(),
            'page' => $this->belongsToMany(Page::class, 'page_bookmark')->withTimestamps(),
            'ayah' => $this->belongsToMany(Ayah::class, 'ayah_bookmark')->withTimestamps(),
        ];
    }

    // General method to check if an item is bookmarked
    public function hasBookmarked($type, $item)
    {
        $relationship = $this->bookmarks()[$type] ?? null;

        if ($relationship) {
            return $relationship->where($type . '_id', $item->_id)->exists();
        }

        return false;
    }

    // General method to add or remove bookmark
    public function toggleBookmark($type, $item)
    {
        $relationship = $this->bookmarks()[$type] ?? null;

        if ($relationship) {
            if ($this->hasBookmarked($type, $item)) {
                $relationship->detach($item);
            } else {
                $relationship->attach($item);
            }
        }
    }
}
