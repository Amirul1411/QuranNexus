<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Laravel\Sanctum\Contracts\HasAbilities;

class PersonalAccessToken extends Model implements HasAbilities
{
    protected $connection = 'mongodb';
    protected $collection = 'personal_access_tokens';

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'tokenable_id',
        'tokenable_type',
        'last_used_at',
        'expires_at'
    ];

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function tokenable()
    {
        return $this->morphTo('tokenable');
    }

    public function can($ability)
    {
        return in_array('*', $this->abilities) ||
               in_array($ability, $this->abilities);
    }

    public function cant($ability)
    {
        return ! $this->can($ability);
    }
}
