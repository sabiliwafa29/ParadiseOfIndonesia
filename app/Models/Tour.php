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

    /**
     * Scope: Filter by target market
     */
    public function scopeForMarket($query, $market = 'both')
    {
        if ($market === 'domestic') {
            return $query->whereIn('target_market', ['domestic', 'both']);
        } elseif ($market === 'international') {
            return $query->whereIn('target_market', ['international', 'both']);
        }
        return $query; // both
    }

    /**
     * Get user's market based on location
     */
    public static function getUserMarket()
    {
        $userCountry = self::detectUserCountry();
        
        if ($userCountry === 'ID') {
            return 'domestic';
        } else {
            return 'international';
        }
    }

    /**
     * Detect user country
     */
    public static function detectUserCountry()
    {
        // Method 1: Using GeoIP (recommended)
        // if (class_exists('\Stevebauman\Location\Facades\Location')) {
        //     try {
        //         $position = \Stevebauman\Location\Facades\Location::get(request()->ip());
        //         return $position ? $position->countryCode : 'US';
        //     } catch (\Exception $e) {
        //         return 'US';
        //     }
        // }

        // Method 2: Using IP geolocation API (free)
        try {
            $response = \Illuminate\Support\Facades\Http::get('https://ipapi.co/' . request()->ip() . '/json/');
            return $response->json('country_code') ?? 'US';
        } catch (\Exception $e) {
            return 'US';
        }

        return 'US'; // Default fallback
    }

    /**
     * Get tour price for user based on location
     */
    public function getPriceForUser(): string
    {
        try {
            $currency = LocationService::getUserCurrency();
            return $this->getFormattedPrice($currency);
        } catch (\Exception $e) {
            \Log::warning("Tour price lookup failed: " . $e->getMessage());
            return $this->getFormattedPrice('USD');
        }
    }

    /**
     * Check if tour is available for user
     */
    public function isAvailableForUser(): bool
    {
        $userMarket = self::getUserMarket();
        return $this->forMarket($userMarket)->where('id', $this->id)->exists();
    }

    // Relasi ke Bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Accessor untuk status jika belum ada kolom status di database
    public function getStatusAttribute($value)
    {
        // Jika kolom status ada di database, return value asli
        if (isset($this->attributes['status'])) {
            return $value;
        }
        
        // Jika tidak ada, return 'active' sebagai default
        return 'active';
    }

    // Accessor untuk bookings_count (opsional, untuk fallback)
    public function getBookingsCountAttribute()
    {
        // Cek apakah sudah ada attribut bookings_count dari withCount
        if (array_key_exists('bookings_count', $this->attributes)) {
            return $this->attributes['bookings_count'];
        }
        
        // Jika model Booking tidak ada, return 0
        if (!class_exists('App\Models\Booking')) {
            return 0;
        }
        
        // Hitung bookings
        return $this->bookings()->count();
    }

    /**
     * Get price by currency
     */
    public function getPriceByCurrency(string $currency = 'USD'): float
    {
        return match($currency) {
            'IDR' => (float) $this->price_idr,
            'CNY' => (float) $this->price_cny,
            'USD' => (float) $this->price_usd,
            default => (float) $this->price_usd,
        };
    }

    /**
     * Format price with currency symbol
     */
    public function getFormattedPrice(string $currency = 'USD'): string
    {
        $price = $this->getPriceByCurrency($currency);
        
        return match($currency) {
            'IDR' => 'Rp ' . number_format($price, 0, ',', '.'),
            'CNY' => '¥ ' . number_format($price, 2, '.', ','),
            'USD' => '$ ' . number_format($price, 2, '.', ','),
            default => '$ ' . number_format($price, 2, '.', ','),
        };
    }

    /**
     * Auto-convert USD to other currencies
     */
    public function autoConvertPrices(): void
    {
        if ($this->price_usd) {
            $this->price_idr = $this->price_usd * $this->exchange_rate_idr;
            $this->price_cny = $this->price_usd * $this->exchange_rate_cny;
        }
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
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Provide a URL attribute for compatibility with parts of the codebase
     * that expect $tour->url or getUrlAttribute(). Uses named route when
     * available and falls back to slug or id.
     */
    public function getUrlAttribute()
    {
        return route('tours.show', $this);
    }


}