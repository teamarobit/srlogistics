/* =====================================================================
   SR Logistics — Tyre Vendor Module V2 (Gate 1 preview interactions)
   Supplements V2/customer.js (theme + base interactions). External only (SD-1).
   Adds the Tyre-Vendor-specific widgets: bank repeater (E3), TDS Declaration
   conditional (E6), GST-treatment conditional. No `size` field exists (E7).
   ===================================================================== */
$(function () {
    'use strict';

    /* ---- E3: Bank-details repeater (clean template, single Primary) ---- */
    var bankIdx = 1;
    function cv2BankRowHtml(i) {
        return '<div class="cv2-repeat-row">' +
            '<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>' +
            '<div class="cv2-form-grid is-3">' +
            '<div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><input type="text" name="bank[]" placeholder="Bank name"></div>' +
            '<div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" placeholder="Account no"></div>' +
            '<div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" placeholder="IFSC"></div>' +
            '<div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" placeholder="name@bank"></div>' +
            '<div class="cv2-field"><label class="cv2-label">Primary?</label>' +
            '<div class="cv2-radio-group"><span class="cv2-radio"><input type="radio" name="is_primary" id="bp_' + i + '" value="' + i + '"><label for="bp_' + i + '">Primary</label></span></div>' +
            '</div>' +
            '</div></div>';
    }
    $('#cv2AddBank').on('click', function () {
        $('#cv2BankWrap').append(cv2BankRowHtml(bankIdx++));
    });
    $('#cv2BankWrap').on('click', '.cv2-remove', function () {
        $(this).closest('.cv2-repeat-row').remove();
    });

    /* ---- GST treatment -> GST Number required only when Registered ---- */
    function syncGst() {
        var v = $('#cv2GstTreatment').val();
        $('.cv2-cond[data-gst]').hide();
        if (v) $('.cv2-cond[data-gst="' + v + '"]').show();
    }
    $('#cv2GstTreatment').on('change', syncGst);
    if ($('#cv2GstTreatment').length) syncGst();

    /* ---- E6: TDS Declaration mandatory when tds_percentage is 0 or 1 ---- */
    function syncTdsDecl() {
        var raw = $('#cv2TdsPct').val();
        var n = parseFloat(raw);
        var due = (raw !== '' && (n === 0 || n === 1));
        $('#cv2TdsDeclWrap').toggle(due);
    }
    $('#cv2TdsPct').on('input change', syncTdsDecl);
    if ($('#cv2TdsPct').length) syncTdsDecl();
});
