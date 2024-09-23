<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Translation extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'translations';

    protected $fillable = [
        '_id',
        'name',
        'translator',
        'language',
        'translation',
    ];

    protected $casts = [
        'translation' => 'array',
    ];

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_index', 'ayah_index')
        ->where('surah_id', $this->surah_id);;
    }
}
