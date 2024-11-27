<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use MongoDB\Laravel\Eloquent\Model;

class Achievement extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'achievements';

    protected $fillable = [
        '_id',
        'badge_image',
        'title',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        // Listen to the updating event
        static::updating(function ($model) {
            $originalBadgeImage = $model->getOriginal('badge_image');

            // Check if the image is being updated
            if ($originalBadgeImage && $originalBadgeImage !== $model->badge_image) {
                // Delete the old image from S3
                Storage::delete($originalBadgeImage);
            }
        });

        // You can also handle deletion for when the model is deleted
        static::deleting(function ($model) {
            if ($model->badge_image) {
                Storage::delete($model->badge_image);
            }
        });
    }

}
