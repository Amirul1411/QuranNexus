<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Surah extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'surahs';

    protected $fillable = [
        '_id',
        'name',
        'tname',
        'ename',
        'ayas',
    ];

    public function ayah()
    {
        return $this->hasMany(Ayah::class, 'surah_id', '_id');
    }
}
