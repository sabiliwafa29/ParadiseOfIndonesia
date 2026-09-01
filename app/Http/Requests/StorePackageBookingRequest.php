<?php

namespace App\Http\Requests;

use App\Models\TourPackage;
use Illuminate\Foundation\Http\FormRequest;

class StorePackageBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $package = $this->route('package');
        $minGuests = $package instanceof TourPackage ? ($package->min_guests ?? 1) : 1;

        return [
            'full_name' => 'required|string|max:255',
            'contact_handle' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'route_option' => 'required|in:ijen,tabuhan',
            'date' => 'required|date|after_or_equal:today',
            'guests' => "required|integer|min:{$minGuests}|max:50",
            'guide' => 'sometimes|boolean',
            'transport' => 'sometimes|boolean',
            'special_link_token' => 'sometimes|nullable|string|exists:special_links,token',
        ];
    }

    public function messages(): array
    {
        $package = $this->route('package');
        $minGuests = $package instanceof TourPackage ? ($package->min_guests ?? 1) : 1;

        return [
            'guests.min' => "Minimal {$minGuests} tamu diperlukan untuk paket ini.",
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'guide' => (bool) ($this->has('guide') && $this->guide),
            'transport' => (bool) ($this->has('transport') && $this->transport),
        ]);
    }
}