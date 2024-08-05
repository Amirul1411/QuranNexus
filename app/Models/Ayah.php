<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Ayah extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'ayahs';

    protected $fillable = [
        '_id',
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

    // public function translations()
    // {
    //     return $this->hasMany(Translation::class, 'ayah_index', 'ayah_index');
    // }
}
