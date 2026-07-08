<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PpNotesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // route is inside the auth middleware group
    }

    public function rules(): array
    {
        return [
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
