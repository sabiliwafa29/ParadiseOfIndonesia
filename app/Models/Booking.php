<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_id',
        'package_id',
        'full_name',
        'contact_handle',
        'email',
        'route_option',
        'date',
        'guests',
        'guide_service',
        'transport_service',
        'addon_cost',
        'total_price',
        'currency',
        'status',
        'payment_id',
        'payment_status',
        'payment_method',
        'order_id',
    ];

    protected $casts = [
        'date' => 'date',
        'guide_service' => 'boolean',
        'transport_service' => 'boolean',
        'addon_cost' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }

    public function getStatusAttribute(): string
    {
        return $this->attributes['status'] ?? 'active';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid' || $this->status === 'confirmed';
    }

    public function canBeCancelled(): bool
    {
        return $this->status === 'pending' && $this->payment_status !== 'paid';
    }

    public function getFormattedTotalPrice(): string
    {
        return \App\Helpers\LanguageHelper::formatPriceByCurrency($this->total_price, $this->currency);
    }
}