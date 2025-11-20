<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TourActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'name',
        'slug',
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

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->name);
            }
        });

        static::updating(function ($activity) {
            if ($activity->isDirty('name') && empty($activity->slug)) {
                $activity->slug = Str::slug($activity->name);
            }
        });
    }

    /**
     * Get the tour that owns the activity.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get the destination through tour.
     */
    public function destination()
    {
        return $this->hasOneThrough(
            Destination::class,
            Tour::class,
            'id', // Foreign key on tours table
            'id', // Foreign key on destinations table
            'tour_id', // Local key on tour_activities table
            'destination_id' // Local key on tours table
        );
    }

    /**
     * Get destination directly via tour relationship.
     */
    public function getDestinationAttribute()
    {
        return $this->tour ? $this->tour->destination : null;
    }
}
