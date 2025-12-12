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
}
