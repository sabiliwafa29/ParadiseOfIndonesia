<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class TravelService extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'image_derivatives' => 'array',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(TravelServiceBooking::class);
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

            if (Storage::disk('public')->exists($this->image)) {
                return Storage::disk('public')->url($this->image);
            }

            return asset('storage/' . ltrim($this->image, '/'));
        }

        return asset('images/services/airport-transfer.jpg');
    }

    public function getPrice(): float
    {
        return (float) ($this->price ?? 0);
    }

    public function getFormattedPrice(?string $locale = null): string
    {
        return format_price($this->getPrice(), $locale);
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->getFormattedPrice();
    }
}
