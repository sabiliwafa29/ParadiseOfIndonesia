<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sudah dilindungi oleh route (sekarang public), jadi biarkan true
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'      => 'required|string|max:255',
            'contact_handle' => 'required|string|max:255',
            'email'          => 'required|email|max:255',

            'route_option'   => 'required|in:ijen,tabuhan',

            'date'    => 'required|date|after_or_equal:today',
            'guests'  => 'required|integer|min:2|max:50',
            'guide'   => 'sometimes|boolean',
            'transport' => 'sometimes|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'guide'     => $this->has('guide') ? (bool) $this->guide : false,
            'transport' => $this->has('transport') ? (bool) $this->transport : false,
        ]);
    }
}
