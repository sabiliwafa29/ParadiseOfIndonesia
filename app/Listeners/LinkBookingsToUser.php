<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class LinkBookingsToUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event - Link existing bookings to newly registered user
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;
        
        // Find all bookings with this email but no user_id
        $bookings = Booking::where('email', $user->email)
            ->whereNull('user_id')
            ->get();
        
        if ($bookings->count() > 0) {
            // Update bookings to link to this user
            Booking::where('email', $user->email)
                ->whereNull('user_id')
                ->update(['user_id' => $user->id]);
            
            Log::info('Linked bookings to newly registered user', [
                'user_id' => $user->id,
                'email' => $user->email,
                'bookings_count' => $bookings->count(),
            ]);
        }
    }
}
