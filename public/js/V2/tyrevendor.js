/* =====================================================================
   SR Logistics — Tyre Vendor Module V2 (Gate 2 — live AJAX wiring)
   Self-contained. External JS only (SD-1). jQuery + Select2 + intl-tel-input
   + SweetAlert2. All submits via $.ajax (SD-3). Toast.fire (SD-7). Validation
   errors as red text below the field, never red borders (SD-4).
   E3 bank repeater (one primary) · E6 TDS Declaration conditional · E7 no size.
   ===================================================================== */
$(function () {
    'use strict';

    var CSRF = $('meta[name="csrf-token"]').attr('content');

    var Toast = Swal.mixin({
        toast: true, position: 'top', showConfirmButton: false,
        timer: 3000, timerProgressBar: true,
        didOpen: function (t) {
            t.addEventListener('mouseenter', Swal.stopTimer);
            t.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });

    /* ---------------- SD-4 validation error helpers ---------------- */
    function clearValidationErrors(scope) {
        (scope ? $(scope) : $(document)).find('.field-error').remove();
    }
    function errorTargets(field) {
        var $t = $('[name="' + field + '"]');
        if ($t.length) { return $t; }
        if (field.indexOf('.') > -1) {
            var parts = field.split('.');
            var base = parts.shift();
            var idx = parts.join('.');
            $t = $('[name="' + base + '[' + idx + ']"]');
            if ($t.length) { return $t; }
            $t = $('[name="' + base + '[]"]').eq(parseInt(idx, 10) || 0);
            if ($t.length) { return $t; }
            $t = $('[name="' + base + '"]');
            if ($t.length) { return $t; }
        }
        var m = field.match(/^(.*)_(\d+)$/);
        if (m) {
            $t = $('[name="' + m[1] + '[' + m[2] + ']"]');
            if ($t.length) { return $t; }
        }
        return $();
    }
    function showValidationErrors(errors) {
        clearValidationErrors();
        if (!errors) { return; }
        $.each(errors, function (field, messages) {
            var msg = Array.isArray(messages) ? messages[0] : messages;
            var $input = errorTargets(field);
            if ($input.length) {
                var $field = $input.closest('.cv2-field');
                var $span = $('<span class="text-danger small d-block mt-1 field-error"></span>').text(msg);
                if ($field.length) { $field.append($span); } else { $span.insertAfter($input); }
            } else {
                // surface field-less errors (e.g. primary_bank, tds_declaration) as a toast
                Toast.fire({ icon: 'error', title: msg });
            }
        });
        var $first = $('.field-error').first();
        if ($first.length) {
            var $modal = $first.closest('.modal');
            if ($modal.length && $modal.hasClass('show')) {
                $modal.animate({ scrollTop: $modal.scrollTop() + $first.position().top - 80 }, 300);
            } else {
                $('html, body').animate({ scrollTop: $first.offset().top - 120 }, 300);
            }
        }
    }
    function extractErrors(xhr) {
        var j = xhr.responseJSON || {};
        if (j.errors) { return j.errors; }
        if (j.data && typeof j.data === 'object' && !Array.isArray(j.data)) { return j.data; }
        return null;
    }
    function handleAjaxError(xhr) {
        if (xhr.status === 422) {
            var errs = extractErrors(xhr);
            if (errs) { showValidationErrors(errs); }
            var m = (xhr.responseJSON || {}).message;
            if (m) { Toast.fire({ icon: 'error', title: m }); }
        } else {
            Toast.fire({ icon: 'error', title: (xhr.responseJSON || {}).message || 'Something went wrong.' });
        }
    }

    /* ---------------- intl-tel-input (SD-13) ---------------- */
    var itiMap = [];
    function initPhone(el) {
        if (!el || el.dataset.itiDone === '1') { return; }
        if (typeof window.intlTelInput !== 'function') { return; }
        var iti = window.intlTelInput(el, {
            initialCountry: 'in', separateDialCode: true, preferredCountries: ['in'],
            utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js'
        });
        el.dataset.itiDone = '1';
        var saved = el.value;
        if (saved) { try { iti.setNumber(saved); } catch (e) {} }
        itiMap.push({ el: el, iti: iti });
    }
    function initAllPhones(scope) {
        (scope ? $(scope) : $(document)).find('input[data-intl-phone="1"]').each(function () { initPhone(this); });
    }
    initAllPhones();

    // Before serialize: national digits in the input; dial code into <name>_code hidden if present.
    function preparePhones($scope) {
        itiMap.forEach(function (rec) {
            if ($scope && !($.contains($scope[0], rec.el) || $scope[0] === rec.el)) { return; }
            try {
                var cd = rec.iti.getSelectedCountryData();
                var name = $(rec.el).attr('name') || '';
                rec.el.value = (rec.el.value || '').replace(/\D/g, '');
                if (name && name.indexOf('[]') === -1) {
                    var $code = $('[name="' + name + '_code"]');
                    if ($code.length && cd && cd.dialCode) { $code.val('+' + cd.dialCode); }
                }
            } catch (e) {}
        });
    }

    /* ---------------- Select2 ---------------- */
    function initSelect2(scope) {
        (scope ? $(scope) : $(document)).find('.cv2-select').not('.cv2-modal-select').filter(function () {
            return $(this).closest('.cv2-filters').length === 0 && !$(this).hasClass('select2-hidden-accessible');
        }).each(function () {
            try { $(this).select2({ width: '100%', placeholder: $(this).find('option:first').text() }); } catch (e) {}
        });
    }
    initSelect2();
    $('.cv2-modal').on('shown.bs.modal', function () {
        var $modal = $(this);
        $modal.find('.cv2-modal-select').each(function () {
            if ($(this).hasClass('select2-hidden-accessible')) { return; }
            try { $(this).select2({ width: '100%', dropdownParent: $modal, placeholder: $(this).find('option:first').text() }); } catch (e) {}
        });
        initAllPhones($modal);
    });

    /* ---------------- State -> City cascade ---------------- */
    function populateCities($state) {
        var targetSel = $state.data('city-target');
        if (!targetSel) { return; }
        var $city = $(targetSel);
        var oldVal = $city.data('old');
        var $opt = $state.find('option:selected');
        var cities = [];
        try { cities = $opt.attr('data-cities') ? JSON.parse($opt.attr('data-cities')) : []; } catch (e) { cities = []; }
        $city.empty().append(new Option('Choose city…', ''));
        cities.forEach(function (c) {
            var o = new Option(c.name, c.id);
            if (oldVal && String(oldVal) === String(c.id)) { o.selected = true; }
            $city.append(o);
        });
        $city.trigger('change.select2');
    }
    $(document).on('change', '.cv2-state', function () { populateCities($(this)); });

    /* ---------------- GST treatment -> GST Number conditional ---------------- */
    function syncGst() {
        var v = $('#cv2GstTreatment').val();
        $('.cv2-cond[data-gst]').hide();
        if (v) { $('.cv2-cond[data-gst="' + v + '"]').show(); }
    }
    $(document).on('change', '#cv2GstTreatment', syncGst);
    if ($('#cv2GstTreatment').length) { syncGst(); }

    /* ---------------- E6 TDS Declaration conditional (0 or 1) ---------------- */
    function syncTdsDecl() {
        var raw = $('#cv2TdsPct').val();
        var n = parseFloat(raw);
        var due = (raw !== '' && (n === 0 || n === 1));
        $('#cv2TdsDeclWrap').toggle(due);
    }
    $(document).on('input change', '#cv2TdsPct', syncTdsDecl);
    if ($('#cv2TdsPct').length) { syncTdsDecl(); }

    /* ---------------- Status -> blacklist reason toggle ---------------- */
    function syncStatus() {
        $('#cv2BlacklistWrap').toggle($('#cv2Status').val() === 'Blacklisted');
    }
    $(document).on('change', '#cv2Status', syncStatus);
    if ($('#cv2Status').length) { syncStatus(); }

    /* ---------------- E3 bank repeater (exactly one primary) ---------------- */
    function bankOptionsHtml() {
        var $first = $('#cv2BankWrap .cv2-bank-row select[name="bank_id[]"]').first();
        return $first.length ? $first.html() : '<option value="">Choose bank</option>';
    }
    function cv2BankRowHtml() {
        return '<div class="cv2-bank-row">' +
            '<button type="button" class="cv2-remove" title="Remove bank"><i class="bi bi-x-lg"></i></button>' +
            '<input type="hidden" name="contact_bank_id[]" value="">' +
            '<div class="cv2-bank-head">' +
              '<label class="cv2-primary-pick"><input type="radio" name="primary_bank" value=""> Set as primary account</label>' +
            '</div>' +
            '<div class="cv2-form-grid is-3">' +
              '<div class="cv2-field"><label class="cv2-label">Bank <span class="req">*</span></label><select class="cv2-select cv2-plain" name="bank_id[]" style="width:100%;">' + bankOptionsHtml() + '</select></div>' +
              '<div class="cv2-field"><label class="cv2-label">Beneficiary Name</label><input type="text" name="beneficiary_name[]"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Account Number <span class="req">*</span></label><input type="text" name="account_number[]"></div>' +
              '<div class="cv2-field"><label class="cv2-label">IFSC Code <span class="req">*</span></label><input type="text" name="ifsc_code[]"></div>' +
              '<div class="cv2-field"><label class="cv2-label">UPI ID</label><input type="text" name="upi_id[]"></div>' +
            '</div></div>';
    }
    $('#cv2AddBank').on('click', function () {
        var $row = $(cv2BankRowHtml()).appendTo('#cv2BankWrap');
        try { $row.find('select[name="bank_id[]"]').select2({ width: '100%' }); } catch (e) {}
        renumberBankPrimary();
    });
    $('#cv2BankWrap').on('click', '.cv2-remove', function () {
        if ($('#cv2BankWrap .cv2-bank-row').length <= 1) {
            Toast.fire({ icon: 'error', title: 'At least one bank account is required.' });
            return;
        }
        $(this).closest('.cv2-bank-row').remove();
        renumberBankPrimary();
    });
    function renumberBankPrimary() {
        $('#cv2BankWrap .cv2-bank-row').each(function (i) {
            $(this).find('input[name="primary_bank"]').val(i);
        });
    }
    renumberBankPrimary();

    /* ---------------- Contact-person repeater (clean template) ---------------- */
    function cv2PersonRowHtml() {
        return '<div class="cv2-repeat-row">' +
            '<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>' +
            '<input type="hidden" name="contact_person_id[]" value="">' +
            '<div class="cv2-form-grid is-3">' +
              '<div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name[]" placeholder="Person name"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Designation</label><input type="text" name="contact_person_designation[]" placeholder="e.g. Sales Head"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone[]" data-intl-phone="1" placeholder="98640 11223"></div>' +
              '<div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp[]" data-intl-phone="1" placeholder="98640 11223"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email[]" placeholder="person@vendor.in"></div>' +
              '<div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" name="contact_person_comment[]" placeholder="Optional"></div>' +
            '</div></div>';
    }
    $('#cv2AddPerson').on('click', function () {
        var $row = $(cv2PersonRowHtml()).appendTo('#cv2PersonWrap');
        initAllPhones($row);
    });
    $('#cv2PersonWrap').on('click', '.cv2-remove', function () { $(this).closest('.cv2-repeat-row').remove(); });

    /* =====================================================================
       CREATE / UPDATE (multipart FormData)
       ===================================================================== */
    function submitVendorForm($form) {
        preparePhones($form);
        renumberBankPrimary();
        clearValidationErrors($form);
        var fd = new FormData($form[0]);
        var $btns = $('button[type="submit"][form="' + $form.attr('id') + '"], #' + $form.attr('id') + ' button[type="submit"]');
        $btns.prop('disabled', true);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: fd,
            processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Saved.' });
                setTimeout(function () {
                    if (res.redirect) { window.location.href = res.redirect; }
                    else { window.location.reload(); }
                }, 900);
            },
            error: function (xhr) { $btns.prop('disabled', false); handleAjaxError(xhr); }
        });
    }
    $('#cv2TyreVendorForm').on('submit', function (e) { e.preventDefault(); submitVendorForm($(this)); });
    $('#cv2EditForm').on('submit', function (e) { e.preventDefault(); submitVendorForm($(this)); });

    /* ---------------- Documents — upload + delete ---------------- */
    $('#cv2DocForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        clearValidationErrors($form);
        var fd = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: fd,
            processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Uploaded.' });
                setTimeout(function () { window.location.reload(); }, 900);
            },
            error: handleAjaxError
        });
    });
    $(document).on('click', '.cv2-del-doc', function () {
        var id = $(this).data('id');
        var url = $(this).data('url');
        Swal.fire({ title: 'Delete this document?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete' })
            .then(function (r) {
                if (!r.isConfirmed) { return; }
                $.post(url, { id: id }, function (res) {
                    Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                    setTimeout(function () { window.location.reload(); }, 900);
                }).fail(handleAjaxError);
            });
    });

    /* ---------------- Activity — add note ---------------- */
    $('#cv2ActivityForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        var $btn  = $form.find('button[type="submit"]').prop('disabled', true);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Note saved.' });
                setTimeout(function () { window.location.reload(); }, 900);
            },
            error: function (xhr) { $btn.prop('disabled', false); handleAjaxError(xhr); }
        });
    });

    /* ---------------- Tyre (E4) — modal add / edit / delete ---------------- */
    var TYRE_SAVE_URL = $('#cv2TyreForm').data('save-url');
    var TYRE_UPDATE_TPL = $('#cv2TyreForm').data('update-url'); // contains __ID__ placeholder

    function resetTyreForm() {
        var $f = $('#cv2TyreForm');
        $f[0].reset();
        $f.attr('action', TYRE_SAVE_URL || $f.attr('action'));
        clearValidationErrors($f);
        $('#cv2TyreModalTitle').text('Add Tyre');
    }
    $('#cv2AddTyreBtn').on('click', function () { resetTyreForm(); });
    $(document).on('click', '.cv2-edit-tyre', function () {
        resetTyreForm();
        var d = $(this).data('tyre') || {};
        var $f = $('#cv2TyreForm');
        if (TYRE_UPDATE_TPL && d.id) { $f.attr('action', TYRE_UPDATE_TPL.replace('__ID__', d.id)); }
        $('#cv2TyreModalTitle').text('Edit Tyre');
        $f.find('[name="tyre_serial_number"]').val(d.tyre_serial_number || '');
        $f.find('[name="tyre_brand"]').val(d.tyre_brand || '');
        $f.find('[name="tyre_model"]').val(d.tyre_model || '');
        $f.find('[name="tyre_size"]').val(d.tyre_size || '');
        $f.find('[name="tyre_purchase_date"]').val(d.tyre_purchase_date || '');
        $f.find('[name="tyre_price"]').val(d.tyre_price || '');
        $f.find('[name="tyre_condition"]').val(d.tyre_condition || 'New').trigger('change.select2');
    });
    $('#cv2TyreForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Tyre saved.' });
                $('#cv2TyreModal').modal('hide');
                setTimeout(function () { window.location.reload(); }, 900);
            },
            error: handleAjaxError
        });
    });
    $(document).on('click', '.cv2-del-tyre', function () {
        var id = $(this).data('id');
        var url = $(this).data('url');
        Swal.fire({ title: 'Delete this tyre?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete' })
            .then(function (r) {
                if (!r.isConfirmed) { return; }
                $.post(url, { id: id }, function (res) {
                    Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                    setTimeout(function () { window.location.reload(); }, 900);
                }).fail(handleAjaxError);
            });
    });

    /* ---------------- List delete (index) ---------------- */
    $(document).on('click', '.cv2-del-vendor', function () {
        var id = $(this).data('id');
        var url = $(this).data('url');
        Swal.fire({ title: 'Delete this tyre vendor?', text: 'This cannot be undone.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete' })
            .then(function (r) {
                if (!r.isConfirmed) { return; }
                $.post(url, { id: id }, function (res) {
                    Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                    setTimeout(function () { window.location.reload(); }, 900);
                }).fail(handleAjaxError);
            });
    });
});
