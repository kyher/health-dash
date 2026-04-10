<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrackerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'required|exists:tracker_categories,id',
            'next_appointment_at' => 'nullable|date',
        ];
    }
}
