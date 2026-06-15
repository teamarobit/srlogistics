/* =====================================================================
   SR Logistics — Vehicle Vendor Module V2 (Gate 1 preview interactions)
   External JS only (SD-1). jQuery + Select2 + intl-tel-input + SweetAlert2.
   Reuses the Customer V2 interaction kit; adds vendor-specific logic:
     E3 bank-details repeater (exactly-one-primary radio)
     E6 GST-treatment + TDS-percentage conditionals
   ===================================================================== */
$(function () {
    'use strict';

    /* SD-7 — Toast mixin (defined once per file) */
    var Toast = Swal.mixin({
        toast: true, position: 'top', showConfirmButton: false,
        timer: 3000, timerProgressBar: true,
        didOpen: function (t) {
            t.addEventListener('mouseenter', Swal.stopTimer);
            t.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    /* Select2 on form selects only (NOT modal selects, NOT compact filter-bar selects) */
    $('.cv2-select').not('.cv2-modal-select').filter(function () {
        return $(this).closest('.cv2-filters').length === 0;
    }).each(function () {
        try { $(this).select2({ width: '100%', placeholder: $(this).find('option:first').text() }); } catch (e) {}
    });

    /* Select2 inside modals — init on show with dropdownParent (frontend-design rule) */
    $('.cv2-modal').on('shown.bs.modal', function () {
        var $modal = $(this);
        $modal.find('.cv2-modal-select').each(function () {
            if ($(this).hasClass('select2-hidden-accessible')) return;
            try {
                $(this).select2({ width: '100%', dropdownParent: $modal, placeholder: $(this).find('option:first').text() });
            } catch (e) {}
        });
    });

    /* SD-13 — intl-tel-input on phone fields */
    document.querySelectorAll('input[data-intl-phone="1"]').forEach(function (el) {
        if (typeof window.intlTelInput === 'function') {
            window.intlTelInput(el, {
                initialCountry: 'in', separateDialCode: true, preferredCountries: ['in'],
                utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js'
            });
        }
    });

    /* ---- GST treatment -> GST number conditional (required when Registered) ---- */
    function syncGstTreatment() {
        var v = $('#cv2GstTreatment').val();
        $('[data-when="gst-registered"]').toggle(v === 'Registered');
    }
    $('#cv2GstTreatment').on('change', syncGstTreatment);
    if ($('#cv2GstTreatment').length) syncGstTreatment();

    /* ---- E6: TDS percentage -> TDS Declaration mandatory note ----
       TDS Declaration (coattachtype_id=7) is required when tds_percentage is 0 or 1. */
    function syncTds() {
        var raw = $('#cv2Tds').val();
        var n = parseFloat(raw);
        var mandatory = (raw !== '' && (n === 0 || n === 1));
        $('#cv2TdsNote').toggle(mandatory);
    }
    $('#cv2Tds').on('input change', syncTds);
    if ($('#cv2Tds').length) syncTds();

    /* ---- E3: Bank-details repeater (exactly one primary) ---- */
    function cv2RefreshPrimary() {
        $('#cv2BankWrap .cv2-bank-row').each(function () {
            var on = $(this).find('input[name="is_primary[]"]').is(':checked');
            $(this).toggleClass('is-primary', on);
            $(this).find('.cv2-bank-badge').toggle(on);
        });
    }
    function cv2BankRowHtml() {
        return '' +
        '<div class="cv2-repeat-row cv2-bank-row">' +
          '<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>' +
          '<div class="cv2-form-grid is-3">' +
            '<div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label>' +
              '<select class="cv2-select cv2-bank-select" name="bank_id[]" style="width:100%;"><option value="">Choose bank</option><option>State Bank of India</option><option>HDFC Bank</option><option>ICICI Bank</option><option>Axis Bank</option></select></div>' +
            '<div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]" placeholder="Account holder"></div>' +
            '<div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]" maxlength="50"></div>' +
            '<div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]" maxlength="20"></div>' +
            '<div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]" maxlength="100" placeholder="name@bank"></div>' +
            '<div class="cv2-field"><label class="cv2-label">Primary</label>' +
              '<label class="cv2-primary-flag"><input type="radio" name="is_primary[]" value="Yes"> Set as primary <span class="cv2-bank-badge" style="display:none;">Primary</span></label></div>' +
          '</div>' +
        '</div>';
    }
    $('#cv2AddBank').on('click', function () {
        var $row = $(cv2BankRowHtml()).appendTo('#cv2BankWrap');
        try { $row.find('.cv2-bank-select').select2({ width: '100%' }); } catch (e) {}
    });
    $('#cv2BankWrap').on('click', '.cv2-remove', function () {
        var wasPrimary = $(this).closest('.cv2-bank-row').find('input[name="is_primary[]"]').is(':checked');
        $(this).closest('.cv2-bank-row').remove();
        if (wasPrimary) { $('#cv2BankWrap .cv2-bank-row:first input[name="is_primary[]"]').prop('checked', true); }
        cv2RefreshPrimary();
    });
    $('#cv2BankWrap').on('change', 'input[name="is_primary[]"]', cv2RefreshPrimary);
    if ($('#cv2BankWrap').length) cv2RefreshPrimary();

    /* ---- Contact-person repeater (create / edit) ---- */
    $('#cv2AddPerson').on('click', function () {
        var $clone = $('#cv2PersonWrap .cv2-repeat-row').first().clone();
        $clone.find('input').val('');
        if ($clone.find('.cv2-remove').length === 0) {
            $clone.prepend('<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>');
        }
        $('#cv2PersonWrap').append($clone);
    });
    $('#cv2PersonWrap').on('click', '.cv2-remove', function () { $(this).closest('.cv2-repeat-row').remove(); });

    /* Dropzone click (visual only in preview) */
    $('.cv2-dropzone').on('click', function () { Toast.fire({ icon: 'info', title: 'File picker opens here (wired at Gate 2).' }); });

    /* Status -> blacklist reason toggle (edit) */
    $('#cv2Status').on('change', function () { $('#cv2BlacklistWrap').toggle($(this).val() === 'Blacklisted'); });

    /* Delete confirm (preview) */
    $(document).on('click', '.cv2-del', function () {
        Swal.fire({
            title: 'Delete this record?', text: 'This cannot be undone.', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) { if (r.isConfirmed) Toast.fire({ icon: 'success', title: 'Deleted (wired at Gate 2).' }); });
    });

    /* Preview: intercept saves so nothing posts during Gate 1 */
    $('form[action="javascript:void(0)"]').on('submit', function (e) {
        e.preventDefault();
        Toast.fire({ icon: 'success', title: 'Design preview — saving is wired at Gate 2.' });
    });
});
