<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration',
        'destination_id',
        'image',
        'itinerary',
        'includes',
        'excludes',
        'featured',
        'status', // Tambahkan ini jika sudah ada kolom status
    ];

    // Relasi ke Destination
    public function destination()
    {
        return $this->belongsTo(Destination::class);
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
}