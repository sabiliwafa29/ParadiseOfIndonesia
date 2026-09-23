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
        'time',
        'slug',
        'location',
        'photo',
        'photo_derivatives',
        'description',
        'highlights',
        'what_to_bring',
        'notes',
    ];

    protected $casts = [
        'highlights' => 'array',
        'what_to_bring' => 'array',
        'photo_derivatives' => 'array',
    ];

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

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function destination()
    {
        return $this->hasOneThrough(Destination::class, Tour::class);
    }

    public function getDestinationAttribute(): ?Destination
    {
        return $this->tour?->destination;
    }

    public function getUrlAttribute(): string
    {
        return route('tour-activities.show', $this);
    }

    public function getPhotoUrlAttribute(): string
    {
        if (!empty($this->photo)) {
            if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
                return $this->photo;
            }

            if (file_exists(public_path($this->photo))) {
                return asset($this->photo);
            }

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->photo)) {
                return \Illuminate\Support\Facades\Storage::disk('public')->url($this->photo);
            }

            return asset('storage/' . ltrim($this->photo, '/'));
        }

        return asset('images/activities/default.jpg');
    }
}