<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;


class UserAchievement extends Model
{
    protected $collection = 'user_achievements';

    protected $fillable = [
        'user_id',
        'achievements'  // This will be an array of achievement objects
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}