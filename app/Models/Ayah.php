<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Ayah extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'ayahs';

    protected $fillable = [
        '_id',
        'page_id',
        'juz_id',
        'surah_id',
        'ayah_index',
        'text',
        'bismillah',
        'isVerified',
    ];

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id', '_id');
    }

    public function words()
    {
        return $this->hasMany(Word::class, 'ayah_index', 'ayah_index')
        ->where('surah_id', $this->surah_id);
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', '_id');
    }

    public function juz()
    {
        return $this->belongsTo(Juz::class, 'juz_id', '_id');
    }

    public function translations()
    {
        return $this->hasOne(Translation::class, 'ayah_index', 'ayah_index')
        ->where('surah_id', $this->surah_id);
    }

    public function audioRecitations()
    {
        return $this->hasOne(AudioRecitation::class, 'ayah_index', 'ayah_index')
        ->where('surah_id', $this->surah_id);
    }
}
