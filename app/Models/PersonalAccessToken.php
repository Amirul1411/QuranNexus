<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Laravel\Sanctum\Contracts\HasAbilities;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Log;

class PersonalAccessToken extends Model implements HasAbilities
{
    protected $connection = 'mongodb';
    protected $collection = 'personal_access_tokens';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'tokenable_type',
        'tokenable_id',
    ];

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
    public function getIdAttribute($value = null)
    {
        return (string)$value;
    }
    public function getIdString()
    {
        return (string)$this->_id;
    }
    public static function findToken($token)
    {
        Log::info('Starting token verification', [
            'token_length' => strlen($token)
        ]);

        if (strpos($token, '|') === false) {
            Log::error('Token format invalid - missing separator');
            return null;
        }

        [$id, $plainTextToken] = explode('|', $token, 2);
        
        Log::info('Token parts', [
            'id' => $id,
            'plain_text_length' => strlen($plainTextToken)
        ]);

        $instance = static::find($id);
        
        if (!$instance) {
            Log::error('Token not found', ['id' => $id]);
            return null;
        }

        Log::info('Token found', [
            'id' => (string)$instance->_id,
            'tokenable_type' => $instance->tokenable_type,
            'tokenable_id' => $instance->tokenable_id
        ]);

        $hashedReceived = hash('sha256', $plainTextToken);
        
        if (!hash_equals($instance->token, $hashedReceived)) {
            Log::error('Token hash mismatch', [
                'stored' => $instance->token,
                'received' => $hashedReceived
            ]);
            return null;
        }

        Log::info('Token verified successfully');
        return $instance;
    }

    public function tokenable()
    {
        return $this->morphTo('tokenable', 'tokenable_type', 'tokenable_id');
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