<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelServiceBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'travel_service_id',
        'pickup_id',
        'pickoff_destination_id',
        'booking_type',
        'schedule_date',
        'schedule_time',
        'distance',
        'total_price',
        'status',
        'payment_id',
        'payment_status',
        'payment_method',
        'order_id',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'schedule_time' => 'datetime',
        'distance' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function travelService()
    {
        return $this->belongsTo(TravelService::class);
    }

    public function pickup()
    {
        return $this->belongsTo(Pickup::class);
    }

    public function pickoffDestination()
    {
        return $this->belongsTo(PickoffDestination::class);
    }
}
