{{-- Battery Vendor V2 — Contact-person repeater row (returned by contactPersonWrapper). --}}
<div class="cv2-repeat-row" data-index="{{ $rowindex }}">
    <button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>
    <input type="hidden" name="contact_person_id[{{ $rowindex }}]" value="">
    <input type="hidden" name="contact_person_ph_code[]" class="cv2-cp-phcode">
    <input type="hidden" name="contact_person_whatsapp_code[]" class="cv2-cp-wacode">
    <div class="cv2-form-grid is-3">
        <div class="cv2-field">
            <label class="cv2-label">Name <span class="req">*</span></label>
            <input type="text" name="contact_person_name[{{ $rowindex }}]" placeholder="Person name">
        </div>
        <div class="cv2-field">
            <label class="cv2-label">Designation <span class="req">*</span></label>
            <input type="text" name="contact_person_designation[{{ $rowindex }}]" placeholder="e.g. Sales Head">
        </div>
        <div class="cv2-field">
            <label class="cv2-label">Phone <span class="req">*</span></label>
            <input type="tel" name="contact_person_phone[{{ $rowindex }}]" data-intl-phone="1" placeholder="98640 11223">
        </div>
        <div class="cv2-field">
            <label class="cv2-label">Email</label>
            <input type="email" name="contact_person_email[{{ $rowindex }}]" placeholder="person@company.in">
        </div>
        <div class="cv2-field">
            <label class="cv2-label">Comment</label>
            <input type="text" name="contact_person_comment[{{ $rowindex }}]" placeholder="Optional">
        </div>
    </div>
</div>
