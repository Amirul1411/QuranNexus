<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Ayah extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'ayahs';
    protected $fillable = ['_id', 'page_id', 'juz_id', 'surah_id', 'ayah_index', 'ayah_key', 'text', 'bismillah', 'isVerified'];
}