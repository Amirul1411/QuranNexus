<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class WordStatistics extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'word_statistics';

    protected $fillable = ['_id', 'word', 'transliteration', 'translation', 'characters', 'total_occurences', 'occurences_by_surah', 'occurences_by_juz', 'occurences_by_page', 'positions'];

}
