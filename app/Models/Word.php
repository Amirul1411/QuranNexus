<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Word extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'words';

    protected $fillable = ['_id', 'surah_id', 'ayah_index', 'word_index', 'ayah_key', 'word_key', 'audio_url', 'page_id', 'line_number', 'text', 'characters', 'translation', 'transliteration'];
}
