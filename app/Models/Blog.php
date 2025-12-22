<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'valid_until',
        'image'
    ];

    protected $casts = [
        'valid_until' => 'date',
    ];
}
