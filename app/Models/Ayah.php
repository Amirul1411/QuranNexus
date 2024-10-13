<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Ayah extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'ayahs';

    protected $fillable = ['_id', 'page_id', 'juz_id', 'surah_id', 'ayah_index', 'ayah_key', 'text', 'bismillah', 'isVerified'];

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id', '_id');
    }

    public function words()
    {
        return $this->hasMany(Word::class, 'ayah_key', 'ayah_key');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', '_id');
    }

    public function juz()
    {
        return $this->belongsTo(Juz::class, 'juz_id', '_id');
    }

    public function tafseer()
    {
        return $this->hasMany(Tafseer::class, 'ayah_key', 'ayah_key');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'ayah_key', 'ayah_key');
    }

    public function audioRecitations()
    {
        return $this->hasMany(AudioRecitation::class, 'ayah_key', 'ayah_key');
    }
}
