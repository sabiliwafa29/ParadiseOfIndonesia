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
        'status',
        'payment_id',
        'payment_status',
        'payment_method',
        'order_id',
    ];

    protected $casts = [
        'date' => 'date'
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
        return $this->belongsTo(\App\Models\TourPackage::class, 'package_id');
    }
}
