<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tour extends Model
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
        'price_usd',
        'price_idr',
        'price_cny',
        'duration',
        'destination_id',
        'image',
        'image_derivatives',
        'itinerary',
        'includes',
        'excludes',
        'featured',
        'status',
        'target_market',
        'exchange_rate_idr',
        'exchange_rate_cny',
        'min_guests',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'itinerary' => 'json',
        'includes' => 'json',
        'excludes' => 'json',
        'price_usd' => 'decimal:2',
        'price_idr' => 'decimal:2',
        'price_cny' => 'decimal:2',
        'min_guests' => 'integer',
        'image_derivatives' => 'json',
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function tourActivities()
    {
        return $this->hasMany(TourActivity::class);
    }

    public function tourPackages(): BelongsToMany
    {
        return $this->belongsToMany(TourPackage::class, 'tour_tour_package', 'tour_id', 'tour_package_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeForMarket($query, $market = 'both')
    {
        return match($market) {
            'domestic' => $query->whereIn('target_market', ['domestic', 'both']),
            'international' => $query->whereIn('target_market', ['international', 'both']),
            default => $query,
        };
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
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
        return route('tours.show', $this);
    }

    public function getPriceByCurrency(string $currency = 'USD'): float
    {
        return match(strtoupper($currency)) {
            'IDR' => (float) $this->price_idr,
            'CNY' => (float) $this->price_cny,
            'USD' => (float) $this->price_usd,
            default => (float) $this->price_usd,
        };
    }

    public function getFormattedPrice(string $currency = 'USD'): string
    {
        $price = $this->getPriceByCurrency($currency);
        return match(strtoupper($currency)) {
            'IDR' => 'Rp ' . number_format($price, 0, ',', '.'),
            'CNY' => '¥ ' . number_format($price, 2, '.', ','),
            'USD' => '$ ' . number_format($price, 2, '.', ','),
            default => '$ ' . number_format($price, 2, '.', ','),
        };
    }

    public function autoConvertPrices(): void
    {
        if ($this->price_usd) {
            $this->price_idr = $this->price_usd * ($this->exchange_rate_idr ?? 15000);
            $this->price_cny = $this->price_usd * ($this->exchange_rate_cny ?? 6.5);
        }
    }

    public function isAvailableForUser(): bool
    {
        $userMarket = \App\Models\Tour::getUserMarket();

        return match($userMarket) {
            'domestic' => in_array($this->target_market, ['domestic', 'both']),
            'international' => in_array($this->target_market, ['international', 'both']),
            default => true,
        };
    }

    public static function getUserMarket(): string
    {
        return \App\Services\LocationService::getUserMarket();
    }

    public static function detectUserCountry(): string
    {
        return \App\Services\LocationService::detectCountry();
    }
}