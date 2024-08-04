<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Juz extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'juzs';

    protected $fillable = [
        '_id',
        'surah_id',
        'ayah_id',
    ];
}
