<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'name',
        'location',
        'photo',
        'description',
        'highlights',
        'what_to_bring',
        'notes',
    ];

    protected $casts = [
        'highlights' => 'array',
        'what_to_bring' => 'array',
    ];
}
