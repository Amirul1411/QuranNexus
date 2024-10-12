<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class TafseerInfo extends Model
{
    // use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'tafseer_info';

    protected $fillable = [
        '_id',
        'name',
        'author_name',
        'slug',
        'language_name',
        'translated_name',
    ];

    public function tafseers()
    {
        return $this->hasMany(Tafseer::class, 'tafseer_info_id', '_id');
    }
}
