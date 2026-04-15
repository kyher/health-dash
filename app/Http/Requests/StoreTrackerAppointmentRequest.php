<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrackerAppointmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'appointment_at' => 'required|date',
        ];
    }
}
