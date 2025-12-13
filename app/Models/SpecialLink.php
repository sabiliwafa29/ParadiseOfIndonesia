<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TourPackage;

class SpecialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'tour_package_id',
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

    public function isValid()
    {
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }
        return true;
    }

    public function priceForCurrency($currency)
    {
        $currency = strtoupper($currency);
        switch ($currency) {
            case 'IDR':
            case 'idr':
                return $this->price_special_idr ?? null;
            case 'USD':
            case 'usd':
                return $this->price_special_usd ?? null;
            case 'CNY':
            case 'cny':
                return $this->price_special_cny ?? null;
            default:
                return $this->price_special_usd ?? $this->price_special_idr ?? $this->price_special_cny ?? null;
        }
    }

    /**
     * Check whether this special link applies to the given guest count.
     */
    public function appliesToGuests(int $guests): bool
    {
        // If fixed_guests is set, only that exact number applies
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
}
