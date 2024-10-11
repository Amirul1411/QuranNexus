<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Translation extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'translations';

    protected $fillable = [
        '_id',
        'surah_id',
        'ayah_index',
        'ayah_key',
        'text',
    ];

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_key', 'ayah_key');
    }
}
