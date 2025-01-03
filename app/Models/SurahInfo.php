<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SurahInfo extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surah_info';

    protected $fillable = [
        '_id',
        'html',
    ];

    public function surah()
    {
        return $this->belongsTo(Surah::class, '_id', '_id');
    }
}
