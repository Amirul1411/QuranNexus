<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'pages';

    protected $fillable = [
        '_id',
        'surah_id',
        'ayah_id',
    ];
}
