<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Word extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'words';

    protected $fillable = [
        '_id',
        'surah_id',
        'ayah_index',
        'word_index',
        'text',
    ];

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_index', 'ayah_index')
        ->where('surah_id', $this->surah_id);;
    }
}
