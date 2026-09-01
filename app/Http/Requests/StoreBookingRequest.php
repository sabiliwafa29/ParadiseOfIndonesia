<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date|after:today',
            'guests' => 'required|integer|min:1|max:50',
            'guide' => 'sometimes|boolean',
            'transport' => 'sometimes|boolean',
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