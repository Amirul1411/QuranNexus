<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Word extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'words';

    protected $fillable = ['_id', 'surah_id', 'ayah_index', 'word_index', 'ayah_key', 'word_key', 'page_id', 'line_number', 'text'];

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_key', 'ayah_key');
    }
}
