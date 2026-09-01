<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id || $user->email === $booking->email;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id || $user->email === $booking->email;
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id || $user->email === $booking->email;
    }

    public function restore(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    public function forceDelete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }
}