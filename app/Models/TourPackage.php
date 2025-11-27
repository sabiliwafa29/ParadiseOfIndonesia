<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TourPackage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name_id',
        'name_en', 
        'name_zh',
        'description_id',
        'description_en',
        'description_zh',
        'price_idr',
        'price_usd',
        'price_cny',
        'image',
        'image_derivatives',
        'includes_guide',
        'includes_transport',
        'itinerary',
    ];

    protected $casts = [
        'image_derivatives' => 'array',
        'itinerary' => 'json',
        'price_idr' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'price_cny' => 'decimal:2',
        'includes_guide' => 'boolean',
        'includes_transport' => 'boolean',
    ];

    /**
     * The tours that belong to the TourPackage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tour_tour_package', 'tour_package_id', 'tour_id');
    }
    
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"name_{$locale}"} ?? $this->name_en;
    }
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_en;
    }

    /**
     * Provide a URL attribute for compatibility (route fallback to slug or id)
     */
    public function getUrlAttribute()
    {
        return route('tour-packages.show', $this);
    }

}
