<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Tafseer extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tafseer';

    protected $fillable = [
        '_id',
        'surah_id',
        'ayah_index',
        'ayah_key',
        'html',
    ];

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_key', 'ayah_key');
    }
}
