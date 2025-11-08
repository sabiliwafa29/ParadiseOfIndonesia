<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelServiceBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // User harus sudah login (dilindungi oleh middleware auth)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pickup_id' => 'required|exists:pickups,id',
            'destination_id' => 'required|exists:pickoff_destinations,id',
            'booking_type' => 'required|in:one-way,round-trip',
            'schedule_date' => 'required|date|after_or_equal:today',
            'schedule_time' => 'required|date_format:H:i',
        ];
    }
}
