<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

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

    // public function getPage(){
    //     $surah = Surah::find($this->surahId);
    //     $ayah = $surah->ayahs()->first();
    //     $page = $ayah->page();

    //     return $page;
    // }
}
