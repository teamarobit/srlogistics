<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'route_name'           => 'required|unique:routes,name',
            'source_state_id'      => 'required|integer|exists:states,id',
            'source_city_id'       => 'required',
            'destination_state_id' => 'required|integer|exists:states,id',
            'destination_city_id'  => 'required',
            'fixed_km'             => 'required|numeric|min:1|max:999999999999999.99999',
            'transit_time_days'    => 'required|integer|min:0|max:365',
            'transit_time_hrs'     => 'required|numeric|min:0|max:999.99',
            'fixed_diesel_bs3_bs4' => 'required|numeric|min:0|max:9999.99',
            'fixed_diesel_bs6'     => 'required|numeric|min:0|max:9999.99',
            'fixed_driver_advance' => 'required|numeric|min:0|max:999999999999999.99999',
            'remarks'              => 'nullable',
            'route_type'           => 'required|in:Line,Local',
            'status'               => 'required|in:Active,Inactive',

            'rto_id'               => 'required|array|min:1',
            'rto_id.*'             => 'required|integer|exists:rtos,id',

            'tollstation_id'       => 'required|array|min:1',
            'tollstation_id.*'     => 'required|integer|exists:tollstations,id',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->sometimes('transit_time_hrs', 'gt:1', function ($input) {
            return (int) $input->transit_time_days === 0;
        });
    }

    public function messages(): array
    {
        return [
            'required' => 'This field is required.',
            'unique'   => 'This value already exists.',
            'numeric'  => 'Only numeric values are allowed.',
            'integer'  => 'Only whole numbers are allowed.',
            'min'      => 'Value must be at least :min.',
            'max'      => 'Maximum allowed value is :max.',
            'in'       => 'Invalid selection.',
            'exists'   => 'Invalid selection.',
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
