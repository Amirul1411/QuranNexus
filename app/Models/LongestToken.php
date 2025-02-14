<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Sushi\Sushi;

class LongestToken extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'longest_token';

    protected $fillable = ['_id', 'surah_id', 'ayah_index', 'word_index', 'ayah_key', 'word_key', 'text', 'length'];

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_key', 'ayah_key');
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id', '_id');
    }

}
