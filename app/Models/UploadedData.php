<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UploadedData extends Model
{
    protected $collection = 'uploaded_data';
    protected $fillable = ['type', 'data', 'uploaded_at'];
}
