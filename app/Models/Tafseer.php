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
        'tafseer_info_id',
        'surah_id',
        'ayah_index',
        'ayah_key',
        'html',
    ];

    public function tafseerInfo()
    {
        return $this->belongsTo(TafseerInfo::class, 'tafseer_info_id', '_id');
    }

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_key', 'ayah_key');
    }
}
