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

    const MECCAN = 'Meccan';
    const MEDINAN = 'Medinan';

    const TYPES = [
        self::MECCAN => 'Meccan',
        self::MEDINAN => 'Medinan',
    ];

    public function ayahs()
    {
        return $this->hasMany(Ayah::class, 'surah_id', '_id');
    }

    public function words()
    {
        return $this->hasMany(Word::class, 'surah_id', '_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'surah_id', '_id');
    }

    public function juzs()
    {
        return $this->hasMany(Juz::class, 'surah_id', '_id');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'surah_id', '_id');
    }

    public function tafseers()
    {
        return $this->hasMany(Tafseer::class, 'surah_id', '_id');
    }

    public function audioRecitations()
    {
        return $this->hasMany(AudioRecitation::class, 'surah_id', '_id');
    }

    public function surahInfo()
    {
        return $this->hasOne(SurahInfo::class, '_id', '_id');
    }
}
