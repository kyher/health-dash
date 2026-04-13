<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrackerNoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:1000',
        ];
    }
}
