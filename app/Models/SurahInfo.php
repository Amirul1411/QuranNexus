<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SurahInfo extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surah_info'; // Specify the collection name

    // Define the fillable fields
    protected $fillable = ['_id', 'html'];
}
