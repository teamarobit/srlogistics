<?php

namespace App\Http\Requests\V2;

use App\Models\Contact;
use App\Models\Coattachment;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Vehicle Vendor V2 — store/update validation.  (cotype_id = 5)
 *
 * One request class serves both create (no route id) and update (route id present).
 * Mirrors the V1 ContactController storeVehiclevendor / updateVehiclevendor rules.
 * Vehicle-vendor specifics (docs/logics/contact/vehiclevendor.md + V2 extensions):
 *   gst_treatment is a real field (Registered/Unregistered); gst_number is required
 *     only when gst_treatment = Registered (NOT hard-coded like Battery E7).
 *   E3 — bank repeater (bank_id[] + primary_bank index), exactly one Primary,
 *        server-enforced in withValidator().
 *   E6 — TDS Declaration (coattachtype_id = 7) mandatory when tds_percentage is
 *        0 or 1. Enforced server-side in withValidator():
 *          · create — the document uploaded in the form must be type 7 (tds 0 or 1);
 *          · update — a type-7 coattachment must already be on file (tds 0),
 *            mirroring the V1 tds === 0 check.
 */
class VehicleVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalise phone fields before validation. The shared V2 intl-tel-input writes
     * the number back in E.164 form (e.g. "+919876543210"); reduce to the national
     * 10-digit number so digits:10 (and the contacts phone + ph_prefix model) holds.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone'    => $this->normalisePhone($this->phone),
            'whatsapp' => $this->normalisePhone($this->whatsapp),
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
            'company_name'                => 'required|max:100',
            'contact_name'                => 'required|max:100',
            'contact_code'                => 'required|max:100',
            'no_of_vehicles'              => 'nullable|integer|min:0',
            'phone'                       => ['required', 'digits:10', $phoneUnique],
            'whatsapp'                    => ['nullable', 'digits:10'],
            'rag_status'                  => 'nullable|in:Red,Yellow,Green',
            'status'                      => 'nullable|in:Active,Inactive,Blacklisted',
            'blacklist_reason'            => 'required_if:status,Blacklisted',
            'contact_comment'             => 'nullable|string|max:255',
            'size'                        => 'nullable|in:Small,Medium,Large',

            'full_company_name'           => 'nullable|max:100',
            'vehicle_ownership_type_id'   => 'nullable|integer|exists:vehicleownerships,id',
            'company_owner'               => 'nullable|max:100',
            'company_registration_no'     => 'nullable|max:100',
            'company_registration_date'   => 'nullable|date|before_or_equal:today',
            'working_since'               => 'nullable|date|before_or_equal:today',
            'pan_no'                      => 'nullable|max:100',
            'pan_status_id'               => 'nullable|integer|exists:panstatuses,id',
            // gst_treatment real field; gst_number required only when Registered.
            'gst_treatment'               => 'nullable|in:Registered,Unregistered',
            'gst_number'                  => 'nullable|required_if:gst_treatment,Registered|max:100',
            'tds_percentage'              => 'nullable|numeric|min:0|max:100',
            'address'                     => 'required|string|max:1000',
            'state_id'                    => 'required|exists:states,id',
            'city_id'                     => 'required|exists:cities,id',
            'post_code'                   => 'required|digits:6',
            'additional_info'             => 'nullable|string|max:10000',

            // E3 — bank repeater (bank_id[] + primary_bank index).
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
            'contact_person_phone.*'      => ['required', 'string', 'distinct'],
            'contact_person_email'        => 'nullable|array',
            'contact_person_email.*'      => 'nullable|email:rfc|distinct',
            'contact_person_comment'      => 'nullable|array',
            'contact_person_comment.*'    => 'nullable|string|max:255',

            // E6 — single document upload on the create form (optional unless TDS rule fires).
            'coattachtype_id'             => 'nullable|exists:coattachtypes,id',
            'attachment_file'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'required'              => 'This field is required.',
            'max'                   => 'Maximum :max characters allowed.',
            'exists'                => "This field's value is invalid.",
            'distinct'              => 'Duplicate value.',
            'email'                 => 'This email is invalid.',
            'phone.digits'          => 'This field must contain 10 digits.',
            'whatsapp.digits'       => 'This field must contain 10 digits.',
            'post_code.digits'      => 'Postal code must be 6 digits.',
            'gst_number.required_if'=> 'GST Number is required when GST Treatment is Registered.',
            'primary_bank.required' => 'At least one bank must be marked as Primary.',
            'mimes'                 => 'File type must be jpg, jpeg, png or pdf.',
        ];
    }

    /** E3 single-Primary rule + E6 TDS Declaration enforcement. */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // E3 — exactly one Primary bank (index must map to a submitted bank row).
            $banks   = (array) $this->input('bank_id', []);
            $primary = $this->input('primary_bank');
            if (count($banks) > 0 && ($primary === null || $primary === '' || ! array_key_exists((int) $primary, $banks))) {
                $validator->errors()->add('primary_bank', 'Select exactly one Primary bank.');
            }

            // E6 — TDS Declaration (coattachtype_id = 7) mandatory when TDS is 0 or 1.
            $tds = $this->input('tds_percentage');
            if ($tds === null || $tds === '') {
                return; // a blank value is not treated as 0.
            }
            $tdsVal = (float) $tds;

            $id = $this->route('id');
            if (! $id) {
                // CREATE — enforce when TDS is 0 or 1; the form's single upload must be the TDS Declaration.
                if (in_array($tdsVal, [0.0, 1.0], true)) {
                    $typeIsTds = (int) $this->input('coattachtype_id') === 7;
                    $hasFile   = $this->hasFile('attachment_file');
                    if (! ($typeIsTds && $hasFile)) {
                        $validator->errors()->add(
                            'attachment_file',
                            'TDS Declaration document is mandatory when TDS % is 0 or 1. Choose type "TDS Declaration" and attach the file.'
                        );
                    }
                }
            } else {
                // UPDATE — mirror V1: when TDS is 0, a type-7 coattachment must already be on file.
                if ($tdsVal === 0.0) {
                    $exists = Coattachment::where('contact_id', $id)->where('coattachtype_id', 7)->exists();
                    if (! $exists) {
                        $validator->errors()->add(
                            'tds_percentage',
                            'TDS Declaration document (type 7) must be on file when TDS % is 0. Upload it on the Documents page first.'
                        );
                    }
                }
            }
        });
    }
}
