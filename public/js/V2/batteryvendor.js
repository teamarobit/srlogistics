/* =====================================================================
   SR Logistics — Battery Vendor Module V2 (Gate 1 preview interactions)
   External JS only (SD-1). Supplements customer.js (shared kit).
   Adds: bank-details repeater (E3) + TDS Declaration conditional (E6).
   ===================================================================== */
$(function () {
    'use strict';

    var bankIdx = $('#cv2BankWrap .cv2-repeat-row').length;

    /* ---- Bank details repeater (E3) — clean template, init Select2 on new row ---- */
    function cv2BankRowHtml(idx) {
        return '' +
        '<div class="cv2-repeat-row">' +
            '<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>' +
            '<div class="cv2-form-grid is-3">' +
                '<div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label>' +
                    '<select class="cv2-select cv2-bank-select" name="bank_id[]" style="width:100%;">' +
                        '<option value="">Choose bank…</option><option>SBI</option><option>HDFC Bank</option><option>ICICI Bank</option><option>Axis Bank</option>' +
                    '</select></div>' +
                '<div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" placeholder="Account number"></div>' +
                '<div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" placeholder="SBIN0001234"></div>' +
                '<div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" placeholder="name@bank"></div>' +
                '<div class="cv2-field"><label class="cv2-label">Primary</label>' +
                    '<div class="cv2-radio-group"><span class="cv2-radio"><input type="radio" name="bank_primary" value="' + idx + '"><label>Primary</label></span></div></div>' +
            '</div>' +
        '</div>';
    }

    $('#cv2AddBank').on('click', function () {
        var $row = $(cv2BankRowHtml(bankIdx++)).appendTo('#cv2BankWrap');
        try { $row.find('.cv2-bank-select').select2({ width: '100%', placeholder: 'Choose bank…' }); } catch (e) {}
    });

    $('#cv2BankWrap').on('click', '.cv2-remove', function () {
        var $row = $(this).closest('.cv2-repeat-row');
        var wasPrimary = $row.find('input[name="bank_primary"]').is(':checked');
        $row.remove();
        /* keep exactly one primary — if we removed it, mark the first remaining row */
        if (wasPrimary && $('#cv2BankWrap input[name="bank_primary"]').length) {
            $('#cv2BankWrap input[name="bank_primary"]').first().prop('checked', true);
        }
    });

    /* ---- TDS Declaration conditional (E6) — required when TDS % is 0 or 1 ---- */
    function cv2SyncTds() {
        var raw = $('#cv2Tds').val();
        var n = parseFloat(raw);
        var due = (raw !== '' && !isNaN(n) && (n === 0 || n === 1));
        $('#cv2TdsNotice').toggle(due);
        $('#cv2TdsDocNotice').toggle(due);
    }
    if ($('#cv2Tds').length) {
        $('#cv2Tds').on('input change', cv2SyncTds);
        cv2SyncTds();
    }
});
