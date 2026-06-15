/* =====================================================================
   SR Logistics — Driver Module V2 (Gate 1 preview interactions)
   External JS only (SD-1). jQuery + Select2 + intl-tel-input + SweetAlert2.
   Reuses the Customer V2 component kit; adds driver-specific behaviour:
   E3 bank repeater (exactly one primary), E5 same-as-permanent copy,
   driverinfo status_type conditional fields.
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

    /* Select2 inside modals — init on show with dropdownParent */
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

    /* daterangepicker (loaded globally in layout) */
    if ($.fn.daterangepicker) {
        $('.cv2-daterange').daterangepicker({
            autoUpdateInput: false, locale: { format: 'DD/MM/YYYY', cancelLabel: 'Clear' }
        });
        $('.cv2-daterange').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' – ' + picker.endDate.format('DD/MM/YYYY'));
        });
        $('.cv2-daterange').on('cancel.daterangepicker', function () { $(this).val(''); });
    }

    /* ---- E5: Present address "same as permanent" copy toggle ---- */
    $('#cv2SameAsPermanent').on('change', function () {
        var on = $(this).is(':checked');
        $('#cv2PresentWrap').toggle(!on);
        if (on) Toast.fire({ icon: 'info', title: 'Present address will mirror the permanent address.' });
    });

    /* ---- E3: Bank details repeater (exactly one primary) ---- */
    function cv2BankRowHtml() {
        return '<div class="cv2-bank-row">' +
            '<button type="button" class="cv2-remove" title="Remove bank"><i class="bi bi-x-lg"></i></button>' +
            '<div class="cv2-bank-head">' +
              '<label class="cv2-primary-pick"><input type="radio" name="is_primary_pick"> Set as primary account</label>' +
            '</div>' +
            '<div class="cv2-form-grid is-3">' +
              '<div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;"><option value="">Choose bank</option><option>SBI</option><option>HDFC</option><option>ICICI</option><option>Axis</option></select></div>' +
              '<div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]"></div>' +
              '<div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]"></div>' +
              '<div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]"></div>' +
            '</div></div>';
    }
    $('#cv2AddBank').on('click', function () {
        var $row = $(cv2BankRowHtml()).appendTo('#cv2BankWrap');
        try { $row.find('select').select2({ width: '100%' }); } catch (e) {}
    });
    $('#cv2BankWrap').on('click', '.cv2-remove', function () {
        if ($('#cv2BankWrap .cv2-bank-row').length <= 1) {
            Toast.fire({ icon: 'error', title: 'At least one bank account is required.' });
            return;
        }
        $(this).closest('.cv2-bank-row').remove();
    });

    /* ---- Emergency / guarantor contact-person repeater ---- */
    $('#cv2AddPerson').on('click', function () {
        var $clone = $('#cv2PersonWrap .cv2-repeat-row').first().clone();
        $clone.find('input').val('');
        if ($clone.find('.cv2-remove').length === 0) {
            $clone.prepend('<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>');
        }
        $('#cv2PersonWrap').append($clone);
    });
    $('#cv2PersonWrap').on('click', '.cv2-remove', function () { $(this).closest('.cv2-repeat-row').remove(); });

    /* ---- driverinfo status_type conditional fields ---- */
    function syncStatusType() {
        var st = $('input[name="status_type"]:checked').val();
        $('[data-st="On Leave"]').toggle(st === 'On Leave');
        $('[data-st="Voluntary Exit"]').toggle(st === 'Voluntary Exit');
    }
    $(document).on('change', 'input[name="status_type"]', syncStatusType);
    if ($('input[name="status_type"]').length) syncStatusType();

    /* Status -> Inactive reveals status_type block; Blacklisted reveals reason */
    function syncStatus() {
        var v = $('#cv2Status').val();
        $('#cv2StatusTypeWrap').toggle(v === 'Inactive');
        $('#cv2BlacklistWrap').toggle(v === 'Blacklisted');
        if (v === 'Inactive') syncStatusType();
    }
    $('#cv2Status').on('change', syncStatus);
    if ($('#cv2Status').length) syncStatus();

    /* Reminder toggle (On Leave) */
    $(document).on('change', 'input[name="set_reminder"]', function () {
        $('#cv2ReminderDays').toggle($('input[name="set_reminder"]:checked').val() === 'Yes');
    });

    /* Legal-case conditional (work experience modal) */
    $(document).on('change', 'input[name="previous_legal_case"]', function () {
        $('[data-legal="Yes"]').toggle($('input[name="previous_legal_case"]:checked').val() === 'Yes');
    });

    /* Dropzone click (visual only in preview) */
    $('.cv2-dropzone').on('click', function () { Toast.fire({ icon: 'info', title: 'File picker opens here (wired at Gate 2).' }); });

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
