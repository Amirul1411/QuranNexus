<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Sushi\Sushi;
use Illuminate\Support\Arr;

class ChaptersInitials extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'chapters_initials';

    protected $fillable = ['_id', 'surah_id', 'ayah_key', 'initials'];

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id', '_id');
    }

    public function ayah()
    {
        return $this->belongsTo(Ayah::class, 'ayah_key', 'ayah_key');
    }

}
