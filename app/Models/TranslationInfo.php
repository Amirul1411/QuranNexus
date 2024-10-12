<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class TranslationInfo extends Model
{
    // use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'translation_info';

    protected $fillable = [
        '_id',
        'name',
        'translator',
        'language',
    ];

    public function translations()
    {
        return $this->hasMany(TranslationInfo::class, 'translation_info_id', '_id');
    }
}
