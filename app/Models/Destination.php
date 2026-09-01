<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'image',
        'featured',
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
}