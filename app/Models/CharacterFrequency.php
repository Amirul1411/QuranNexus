<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Sushi\Sushi;

class CharacterFrequency extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'character_frequency';

    protected $fillable = ['_id', 'character', 'count', 'locations'];
}
