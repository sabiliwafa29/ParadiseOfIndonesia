<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration',
        'destination_id',
        'image',
        'itinerary',
        'includes',
        'excludes',
        'featured'
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
