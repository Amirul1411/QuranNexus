<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ExpertAssignment extends Model
{
    protected $collection = 'expert_assignments';
    protected $fillable = ['expert_id', 'ayah_key', 'word_key', 'assigned_at', 'status'];

    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id', '_id');
    }
}
