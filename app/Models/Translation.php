<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Translation extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'translations';

    protected $fillable = [
        '_id',
        'translation_info_id',
        'surah_id',
        'ayah_index',
        'ayah_key',
        'text',
    ];

    public function translationInfo()
    {
        return $this->belongsTo(TranslationInfo::class, 'translation_info_id', '_id');
    }

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_key', 'ayah_key');
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id', '_id');
    }
}
