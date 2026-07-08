<?php

namespace App\Http\Requests;

use App\Models\PpModule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PpStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // route is inside the auth middleware group
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(PpModule::STATUSES)],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Invalid status value.',
        ];
    }
}
