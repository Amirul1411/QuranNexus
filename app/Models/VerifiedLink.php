<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VerifiedLink extends Model
{
    protected $collection = 'verified_links';
    protected $fillable = ['url', 'status', 'submitted_by', 'submitted_at', 'verified_by', 'verified_at'];
}
