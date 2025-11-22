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
        'price',
        'image',
        'image_derivatives',
        'includes_guide',
        'includes_transport',
        'itinerary',
    ];

    protected $casts = [
        'image_derivatives' => 'array',
        'itinerary' => 'json',
        'price' => 'decimal:2',
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

}
