<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'date' => 'required|date|after:today',
            'guests' => 'required|integer|min:1|max:50',
            'guide' => 'sometimes|boolean',
            'transport' => 'sometimes|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure boolean fields are present
        $this->merge([
            'guide' => $this->has('guide') ? (bool) $this->guide : false,
            'transport' => $this->has('transport') ? (bool) $this->transport : false,
        ]);
    }
}
