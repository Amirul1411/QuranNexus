<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

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

    // public function surahs()
    // {
    //     return $this->belongsTo(Surah::class, 'surah_id', '_id');
    // }

    // public function ayahs()
    // {
    //     return $this->belongsTo(Ayah::class, 'ayah_index', 'ayah_index');
    // }
}
