<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Surah extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'surahs';

    protected $fillable = [
        '_id',
        'name',
        'tname',
        'ename',
        'ayas',
    ];

    public function ayahs()
    {
        return $this->hasMany(Ayah::class, 'surah_id', '_id');
    }

    public function surahBookmarks()
    {
        return $this->belongsToMany(User::class, 'surah_bookmark')->withTimestamps();
    }

}
