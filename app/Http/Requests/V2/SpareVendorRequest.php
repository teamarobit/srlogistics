<?php

namespace App\Http\Requests\V2;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Spare Part Vendor V2 — store/update validation.
 *
 * One request class serves both create (no route id) and update (route id present).
 * Mirrors the V1 ContactController spare* validation: phone uniqueness scoped by
 * ph_prefix, bank repeater with exactly one Primary (driver-V2 shape: bank_id[] +
 * primary_bank index), contact persons required, specialisation optional.
 *
 * TDS rule: per docs/logics/contact/sparevendor.md the spare vendor has NO TDS
 * Declaration enforcement — tds_percentage is validated as an optional number only.
 * The Documents-page banner stays advisory (matches V1 behaviour).
 */
class SpareVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalise phone fields before validation.
     *
     * The shared V2 intl-tel-input writes the number back in E.164 form
     * (e.g. "+919876543210") before serialising. Reduce to the national
     * 10-digit number so the digits:10 rule (and the contacts table's
     * 10-digit + ph_prefix data model, per V1) holds.
     */
    protected function prepareForValidation(): void
    {
        $cpPhones = $this->contact_person_phone;
        if (is_array($cpPhones)) {
            $cpPhones = array_map(fn ($v) => $this->normalisePhone($v), $cpPhones);
        }

        $this->merge([
            'phone'                => $this->normalisePhone($this->phone),
            'whatsapp'             => $this->normalisePhone($this->whatsapp),
            'contact_person_phone' => $cpPhones,
        ]);
    }

    private function normalisePhone($value): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $value);
        if ($digits === '') {
            return null;
        }
        return strlen($digits) > 10 ? substr($digits, -10) : $digits;
    }

    public function rules(): array
    {
        $id   = $this->route('id');
        $code = getPhoneCode();

        $phoneUnique = function ($attribute, $value, $fail) use ($id, $code) {
            $q = Contact::where('phone', $value)->where('ph_prefix', $code);
            if ($id) {
                $q->where('id', '!=', $id);
            }
            if ($q->exists()) {
                $fail('This phone number already exists.');
            }
        };

        return [
            'gst_number'                  => 'nullable|max:100',
            'company_name'                => 'required|max:100',
            'contact_name'                => 'required|max:100',
            'contact_code'                => 'required|max:100',
            'phone'                       => ['required', 'digits:10', $phoneUnique],
            'whatsapp'                    => ['nullable', 'digits:10'],
            'email'                       => 'nullable|email',
            'status'                      => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'            => 'required_if:status,Blacklisted',
            'contact_comment'             => 'nullable|string|max:255',
            'specialisation'              => 'nullable|array',
            'specialisation.*'            => 'nullable|exists:wssparepartscategories,id',
            'full_company_name'           => 'nullable|max:100',
            'company_owner'               => 'nullable|max:100',
            'company_registration_no'     => 'nullable|max:100',
            'company_registration_date'   => 'nullable|date|before_or_equal:today',
            'working_since'               => 'nullable|date|before_or_equal:today',
            'pan_no'                      => 'nullable|max:100',
            'pan_status_id'               => 'nullable|integer|exists:panstatuses,id',
            'tds_percentage'              => 'nullable|numeric|min:0|max:100',
            'address'                     => 'required|string|max:1000',
            'state_id'                    => 'required|exists:states,id',
            'city_id'                     => 'required|exists:cities,id',
            'post_code'                   => 'nullable|digits:6',
            'additional_info'             => 'nullable|string|max:10000',

            // Bank repeater (E3) — driver-V2 shape: bank_id[] + primary_bank index.
            'bank_id'                     => 'required|array|min:1',
            'bank_id.*'                   => 'required|exists:banks,id',
            'beneficiary_name'            => 'nullable|array',
            'beneficiary_name.*'          => 'nullable|string|max:255',
            'account_number'              => 'required|array|min:1',
            'account_number.*'            => 'required|string|max:50',
            'ifsc_code'                   => 'required|array|min:1',
            'ifsc_code.*'                 => 'required|string|max:20',
            'upi_id'                      => 'nullable|array',
            'upi_id.*'                    => 'nullable|string|max:100',
            'primary_bank'                => 'required',

            // Contact persons (relcontacts).
            'contact_person_id'           => 'nullable|array',
            'contact_person_name'         => 'required|array|min:1',
            'contact_person_name.*'       => 'required|string|distinct|min:1',
            'contact_person_designation'  => 'required|array|min:1',
            'contact_person_designation.*'=> 'required|string|min:1',
            'contact_person_phone'        => 'required|array|min:1',
            'contact_person_phone.*'      => ['required', 'digits:10', 'distinct'],
            'contact_person_email'        => 'nullable|array',
            'contact_person_email.*'      => 'nullable|email:rfc|distinct',
        ];
    }

    public function messages(): array
    {
        return [
            'required'      => 'This field is required.',
            'max'           => 'Maximum :max characters allowed.',
            'exists'        => "This field's value is invalid.",
            'distinct'      => 'Duplicate value.',
            'email'         => 'This email is invalid.',
            'phone.digits'  => 'Must be 10 digits.',
            'whatsapp.digits' => 'Must be 10 digits.',
            'contact_person_phone.*.digits' => 'Contact person phone must be 10 digits.',
            'primary_bank.required' => 'At least one bank must be marked as Primary.',
            'tds_percentage.max' => 'TDS percentage cannot exceed 100.',
            'tds_percentage.min' => 'TDS percentage cannot be less than 0.',
        ];
    }

    /** Friendly attribute names so messages read cleanly (D4/B5). */
    public function attributes(): array
    {
        return [
            'company_name'              => 'Company Name',
            'contact_name'              => 'Contact Name',
            'contact_code'              => 'Contact Code',
            'company_registration_date' => 'Company Registration Date',
            'working_since'             => 'Working Since',
            'tds_percentage'            => 'TDS Percentage',
            'post_code'                 => 'Post Code',
            'pan_status_id'             => 'PAN Status',
            'state_id'                  => 'State',
            'city_id'                   => 'City',
            'additional_info'           => 'Additional Info',
        ];
    }

    /** Exactly one Primary bank must be chosen (single-Primary rule). */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $primary  = $this->input('primary_bank');
            $bankIds  = $this->input('bank_id', []);
            // Blank case is handled solely by the `required` rule + messages() entry (D5).
            if ($primary === null || $primary === '') {
                return;
            }
            if (! array_key_exists($primary, $bankIds) && ! in_array((string) $primary, array_map('strval', array_keys($bankIds)), true)) {
                $validator->errors()->add('primary_bank', 'Invalid Primary bank selection.');
            }
        });
    }
}
