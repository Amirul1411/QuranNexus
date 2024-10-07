<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Surah extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'surahs';

    protected $fillable = [
        '_id',
        'name',
        'tname',
        'ename',
        'type',
        'ayas',
    ];

    public function getIntIdAttribute()
    {
        return (int) $this->id;
    }

    public function ayahs()
    {
        return $this->hasMany(Ayah::class, 'surah_id', '_id');
    }

    public function surahInfo()
    {
        return $this->hasOne(SurahInfo::class, '_id', '_id');
    }
}
