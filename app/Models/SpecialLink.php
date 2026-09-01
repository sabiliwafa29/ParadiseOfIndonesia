<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'tour_package_id',
        'tours',
        'price_special_idr',
        'price_special_usd',
        'price_special_cny',
        'expires_at',
        'min_guests',
        'max_guests',
        'fixed_guests',
        'max_uses',
        'used_count',
        'note',
        'created_by',
    ];

    protected $dates = ['expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
        'price_special_idr' => 'decimal:2',
        'price_special_usd' => 'decimal:2',
        'price_special_cny' => 'decimal:2',
        'tours' => 'array',
        'min_guests' => 'integer',
        'max_guests' => 'integer',
        'fixed_guests' => 'integer',
        'used_count' => 'integer',
        'max_uses' => 'integer',
    ];

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }

    public function isValid(float $usedCount = null, int $guestCount = null): bool
    {
        $used = $usedCount ?? $this->used_count;
        $max = $this->max_uses;

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($max !== null && $used >= $max) {
            return false;
        }

        if ($guestCount !== null && !$this->appliesToGuests($guestCount)) {
            return false;
        }

        return true;
    }

    public function priceForCurrency(string $currency): ?float
    {
        $currency = strtoupper($currency);

        return match($currency) {
            'IDR' => $this->price_special_idr ?? null,
            'USD' => $this->price_special_usd ?? null,
            'CNY' => $this->price_special_cny ?? null,
            default => $this->price_special_usd ?? $this->price_special_idr ?? $this->price_special_cny ?? null,
        };
    }

    public function appliesToGuests(int $guests): bool
    {
        if ($this->fixed_guests !== null) {
            return $guests === (int) $this->fixed_guests;
        }

        if ($this->min_guests !== null && $guests < $this->min_guests) {
            return false;
        }

        if ($this->max_guests !== null && $guests > $this->max_guests) {
            return false;
        }

        return true;
    }

    public function token(): string
    {
        return $this->token;
    }
}