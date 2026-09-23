<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_id',
        'name_en',
        'name_zh',
        'slug',
        'description_id',
        'description_en',
        'description_zh',
        'location',
        'image',
        'featured',
        'image_derivatives',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'image_derivatives' => 'json',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function tourActivities()
    {
        return $this->hasManyThrough(TourActivity::class, Tour::class);
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->{"name_{$locale}"} ?? $this->name_en;
    }

    public function getDescriptionAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->{"description_{$locale}"} ?? $this->description_en;
    }

    public function getUrlAttribute(): string
    {
        return route('destinations.show', $this);
    }

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }

            if (file_exists(public_path($this->image))) {
                return asset($this->image);
            }

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
                return \Illuminate\Support\Facades\Storage::disk('public')->url($this->image);
            }

            return asset('storage/' . ltrim($this->image, '/'));
        }

        return asset('images/Danau-Toba.png');
    }
}