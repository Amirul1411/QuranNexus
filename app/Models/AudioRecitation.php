<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class AudioRecitation extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'audio_recitations';

    protected $fillable = [
        '_id',
        'surah_id',
        'ayah_index',
        'ayah_key',
        'audio_url',
    ];

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_key', 'ayah_key');
    }
}
