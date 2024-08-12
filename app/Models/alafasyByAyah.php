<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class alafasyByAyah extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'alafasy_by_ayah';

    protected $fillable = [
        'filename', 'file'
    ];
}
