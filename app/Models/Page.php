<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Page extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'pages';

    protected $fillable = [
        '_id',
        'surah_id',
        'ayah_id',
    ];

    public function ayahs()
    {
        return $this->hasMany(Ayah::class, 'page_id', '_id');
    }

    public function pageBookmarks()
    {
        return $this->belongsToMany(User::class, 'page_bookmark')->withTimestamps();
    }

    // public function getPage(){
    //     $surah = Surah::find($this->surahId);
    //     $ayah = $surah->ayahs()->first();
    //     $page = $ayah->page();

    //     return $page;
    // }
}
