<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Laravel\Sanctum\Contracts\HasAbilities;
use Illuminate\Support\Facades\Log;
class PersonalAccessToken extends Model implements HasAbilities
{
    protected $connection = 'mongodb';
    protected $collection = 'personal_access_tokens';

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'tokenable_type',
        'tokenable_id',
        'last_used_at',
        'expires_at'
    ];

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public static function findToken($token)
    {
        Log::info('Starting token verification', [
            'received_token' => $token
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

        // Find token record by ID
        $instance = static::find($id);
        
        if (!$instance) {
            Log::error('Token record not found for ID', ['id' => $id]);
            return null;
        }

        Log::info('Token record found', [
            'stored_token_length' => strlen($instance->token),
            'tokenable_type' => $instance->tokenable_type,
            'tokenable_id' => $instance->tokenable_id
        ]);

        // Hash the received plain text token
        $hashedReceived = hash('sha256', $plainTextToken);
        
        Log::info('Token comparison', [
            'hashed_received' => $hashedReceived,
            'stored_hash' => $instance->token,
            'match' => hash_equals($instance->token, $hashedReceived)
        ]);

        if (hash_equals($instance->token, $hashedReceived)) {
            Log::info('Token verified successfully');
            return $instance;
        }

        Log::error('Token hash mismatch');
        return null;
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