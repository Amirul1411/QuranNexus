<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
class WordStatistic extends Model
{
    protected $connection = 'mongodb'; // Assuming 'mongodb' is your connection name in database.php
    protected $collection = 'word_statistics';
    // Add fillable properties if you use mass assignment, though not strictly needed for 'first()'
    // protected $fillable = ['word', 'transliteration', ...];
}