<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Juz extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'juzs';

    protected $fillable = [
        '_id',
        'surah_id',
        'ayah_index',
        'ayah_key',
    ];

    public function ayahs()
    {
        return $this->hasMany(Ayah::class, 'juz_id', '_id');
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id', '_id');
    }
}
