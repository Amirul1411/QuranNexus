<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Page extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pages';

    protected $fillable = ['_id', 'surah_id', 'ayah_index'];

    public function getFirstAyahTnameAttribute()
    {
        return $this->ayahs->first()?->surah->tname;
    }

    public function ayahs()
    {
        return $this->hasMany(Ayah::class, 'page_id', '_id');
    }
}
