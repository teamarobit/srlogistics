<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $warehouseId = $this->route('warehouse');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('warehouses', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($warehouseId),
            ],
            'warehouse_type'    => 'required|in:Central,Regional,Site/Yard',
            'address'           => 'required|string|max:500',
            'state_id'          => 'required|exists:states,id',
            'city_name'         => 'required|string|max:100',
            'location_name'     => 'nullable|string|max:150',
            'pincode'           => 'nullable|string|max:10',
            'manager_contact_id'=> 'nullable|exists:contacts,id',
            'contact_number'    => 'nullable|digits_between:7,15',
            'storage_type'      => 'nullable|in:Rack,Floor,Open Yard',
            'status'            => 'required|in:Active,Inactive',
            'notes'             => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'required'          => 'This field is required.',
            'in'                => 'Invalid selection.',
            'max'               => 'Too long — max :max characters.',
            'digits_between'    => 'Contact number must be between :min and :max digits.',
            'unique'            => 'A warehouse with this name already exists.',
            'exists'            => 'Invalid selection.',
        ];
    }

    public function attributes(): array
    {
        return [
            'state_id'           => 'state',
            'city_name'          => 'city',
            'manager_contact_id' => 'manager',
            'warehouse_type'     => 'warehouse type',
        ];
    }
}
