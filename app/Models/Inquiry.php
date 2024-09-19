<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'inquiries';

    protected $fillable = [
        '_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'message',
    ];
}
