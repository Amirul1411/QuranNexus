<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Surah extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'surahs'; 

    protected $fillable = [
        'name',
        'tname',
        'ename',
        'type',
        'ayas'
    ];

    public function info()
    {
        return $this->hasOne(SurahInfo::class, '_id', '_id');
    }
}
