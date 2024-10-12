<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class AudioRecitationInfo extends Model
{
    // use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'audio_recitation_info';

    protected $fillable = [
        '_id',
        'reciter_name',
        'style',
        'translated_name',
    ];

    public function audioRecitations()
    {
        return $this->hasMany(AudioRecitation::class, 'audio_info_id', '_id');
    }

}
