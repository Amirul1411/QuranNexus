<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Page extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pages';

    protected $fillable = ['_id', 'surah_id', 'ayah_index', 'ayah_key'];
}
