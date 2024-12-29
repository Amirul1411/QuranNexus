<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DailyQuotes extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'daily_quotes';

    protected $fillable = [
        '_id',
        'title',
        'description',
        'source',
    ];
}
