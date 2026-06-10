<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $branchId = $this->input('branchid');

        return [
            'branch_location' => [
                'required',
                'max:100',
                Rule::unique('branches', 'location')->ignore($branchId, 'id'),
            ],

            'branch_type'                  => 'required|array',
            'branch_type.*'                => 'in:Head Office,Branch Office',

            'start_date'                   => 'nullable|date_format:Y-m-d|before_or_equal:today',
            'branch_code'                  => 'required',
            'branch_head_name'             => 'required',
            //'ph_code'                    => 'nullable',
            'phone'                        => 'required|digits:10',
            'no_of_employee'               => 'required|integer|min:0',
            'address'                      => 'required|string|max:1000',
            'state_id'                     => 'required|exists:states,id',
            'city_id'                      => 'required|exists:cities,id',
            'post_code'                    => 'required|digits:6',
            'branch_ownership'             => 'required|in:Owned,Rental',

            // Conditional: required when branch_ownership == Owned

            // Conditional: required when branch_ownership == Rental
            'branch_owner_name'            => 'exclude_unless:branch_ownership,Rental|required|string|max:255',
            'branch_owner_phone_code'      => 'nullable',
            'branch_owner_phone'           => 'exclude_unless:branch_ownership,Rental|required|digits:10',
            'rent_amount'                  => 'exclude_unless:branch_ownership,Rental|required|numeric|min:1',
            'rent_due_count'               => 'exclude_unless:branch_ownership,Rental|required|integer|min:1|max:20',

            'electricity_service_provider' => 'nullable|string|max:255',
            'electricity_consumer_number'  => 'nullable|max:255',
            'documents'                    => 'nullable|array',
            'documents.*'                  => 'file|max:10240',
            'status'                       => 'required|in:Active,Inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'This field is required.',
            'max'      => 'Maximum 100 characters allowed.',
            'unique'   => 'This value already exists.',
            'numeric'  => 'Only numeric values are allowed.',
            'min'      => 'Value must be at least :min.',
            'in'       => 'Invalid selection.',
            'integer'  => 'Only whole numbers are allowed.',
            'exists'   => 'Invalid selection.',
            'digits'   => 'Must be exactly :digits digits.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'data'    => $validator->errors(),
            'message' => 'Please check validation errors.',
        ], 422));
    }
}
