<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PpUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // route is inside the auth middleware group
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:10240', // 10 MB
                'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,webp',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.max'   => 'File may not be larger than 10 MB.',
            'file.mimes' => 'Allowed types: PDF, Word, Excel, PNG, JPG, WEBP.',
        ];
    }
}
