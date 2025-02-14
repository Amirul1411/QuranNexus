<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Sushi\Sushi;

class DiacriticFrequency extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'diacritic_frequency';

    protected $fillable = ['_id', 'diacritic', 'count', 'locations'];
}
