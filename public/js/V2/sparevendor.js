/* =====================================================================
   SR Logistics — Spare Part Vendor Module V2 (Gate 1 preview)
   Module-specific add-on to customer.js (loaded alongside it).
   External JS only (SD-1). Adds the E3 bank-details repeater + the
   single-Primary radio rule. Person repeater, intl-tel, Select2,
   status->blacklist toggle, delete-confirm, Toast and form-intercept
   all come from customer.js.
   ===================================================================== */
$(function () {
    'use strict';

    /* ---- E3: Bank-details repeater (clean template, no clone) ---- */
    var bankSeq = $('#cv2BankWrap .cv2-repeat-row').length;

    function cv2BankRowHtml(idx) {
        return '<div class="cv2-repeat-row">' +
            '<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>' +
            '<div class="cv2-form-grid is-3">' +
              '<div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><input type="text" name="bank[]" placeholder="Bank name"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" placeholder="Account no"></div>' +
              '<div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" placeholder="SBIN0001234"></div>' +
              '<div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" placeholder="name@bank"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Primary</label>' +
                '<div class="cv2-radio-group"><span class="cv2-radio"><input type="radio" name="is_primary" value="' + idx + '"><label>Primary</label></span></div>' +
              '</div>' +
            '</div>' +
          '</div>';
    }

    $('#cv2AddBank').on('click', function () {
        $('#cv2BankWrap').append(cv2BankRowHtml(bankSeq++));
    });

    $('#cv2BankWrap').on('click', '.cv2-remove', function () {
        var $row = $(this).closest('.cv2-repeat-row');
        var wasPrimary = $row.find('input[name="is_primary"]').is(':checked');
        $row.remove();
        /* Keep exactly one Primary — if we removed it, promote the first remaining row. */
        if (wasPrimary && $('#cv2BankWrap input[name="is_primary"]:checked').length === 0) {
            $('#cv2BankWrap input[name="is_primary"]').first().prop('checked', true);
        }
    });
});
