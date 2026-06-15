/* =====================================================================
   SR Logistics — Employee Module V2 (Gate 1 preview interactions)
   External JS only (SD-1). jQuery + Select2 + intl-tel-input + SweetAlert2.
   Superset of the Customer V2 kit + Employee specifics:
   work-type conditional · same-as-permanent address · asset issue/revoke modals.
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

    /* daterangepicker (effective-from / leave ranges) */
    if ($.fn.daterangepicker) {
        $('.cv2-daterange').daterangepicker({
            autoUpdateInput: false, locale: { format: 'DD/MM/YYYY', cancelLabel: 'Clear' }
        });
        $('.cv2-daterange').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' – ' + picker.endDate.format('DD/MM/YYYY'));
        });
        $('.cv2-daterange').on('cancel.daterangepicker', function () { $(this).val(''); });
    }

    /* ---- Work Type conditional block (Office Work / Service Center) ---- */
    function syncWorkType() {
        var v = $('input[name="workType"]:checked').val() || $('#cv2WorkType').val();
        $('.cv2-cond[data-wt]').hide();
        if (v) $('.cv2-cond[data-wt="' + v + '"]').show();
        syncServiceType();
    }
    /* Service Type (Administrative / Technical) -> skillsets only when Technical */
    function syncServiceType() {
        var st = $('input[name="service_type"]:checked').val();
        $('.cv2-cond[data-st="Technical"]').toggle(st === 'Technical');
    }
    $(document).on('change', 'input[name="workType"], #cv2WorkType', syncWorkType);
    $(document).on('change', 'input[name="service_type"]', syncServiceType);
    if ($('[data-wt]').length) syncWorkType();

    /* ---- E5 same-as-permanent address copy toggle ---- */
    $('#cv2SameAddr').on('change', function () {
        var on = $(this).is(':checked');
        $('#cv2PresentWrap').toggle(!on);
        if (on) Toast.fire({ icon: 'info', title: 'Present address mirrors permanent (wired at Gate 2).' });
    });

    /* ---- Provident Fund number toggle ---- */
    $(document).on('change', 'input[name="providentFund"]', function () {
        $('#cv2PfNoWrap').toggle($('input[name="providentFund"]:checked').val() === 'yes');
    });

    /* ---- Asset issue: asset_type -> list filter hint (visual) ---- */
    $('#cv2AssetType').on('change', function () {
        $('#cv2AssetHint').text($(this).val() ? 'Showing available ' + $(this).val() + ' assets' : '');
    });

    /* ---- Emergency-contact repeater (create / edit) ---- */
    $('#cv2AddPerson').on('click', function () {
        var $clone = $('#cv2PersonWrap .cv2-repeat-row').first().clone();
        $clone.find('input').val('');
        if ($clone.find('.cv2-remove').length === 0) {
            $clone.prepend('<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>');
        }
        $('#cv2PersonWrap').append($clone);
    });
    $('#cv2PersonWrap').on('click', '.cv2-remove', function () { $(this).closest('.cv2-repeat-row').remove(); });

    /* Status -> blacklist reason toggle (edit) */
    $('#cv2Status').on('change', function () { $('#cv2BlacklistWrap').toggle($(this).val() === 'Blacklisted'); });

    /* Dropzone click (visual only in preview) */
    $('.cv2-dropzone').on('click', function () { Toast.fire({ icon: 'info', title: 'File picker opens here (wired at Gate 2).' }); });

    /* Delete / revoke confirm (preview) */
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
