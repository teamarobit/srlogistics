/* =====================================================================
   SR Logistics — Driver Module V2 (Gate 2 — live AJAX wiring)
   External JS only (SD-1). jQuery + Select2 + intl-tel-input + SweetAlert2.
   All form submits via $.ajax (SD-3). Toast.fire for notifications (SD-7).
   Validation errors as field-error spans below the field (SD-4).
   Phone fields: national number in <name>, dial code in <name>_code hidden
   (mirrors V1 ph_prefix + phone split).
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

    /* ---------------- intl-tel-input (national + dial code) ---------------- */
    var itiMap = [];
    function initPhone(el) {
        if (!el || el.dataset.itiDone === '1') { return; }
        if (typeof window.intlTelInput !== 'function') { return; }
        var iti = window.intlTelInput(el, {
            initialCountry: 'in', separateDialCode: true, preferredCountries: ['in'],
            utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js'
        });
        el.dataset.itiDone = '1';
        itiMap.push({ el: el, iti: iti });
    }
    function initAllPhones(scope) {
        (scope ? $(scope) : $(document)).find('input[data-intl-phone="1"]').each(function () { initPhone(this); });
    }
    initAllPhones();

    // Before serialize: keep national digits in the input, write dial code into
    // the paired hidden <name>_code field if one exists.
    function preparePhones($scope) {
        itiMap.forEach(function (rec) {
            if ($scope && !($.contains($scope[0], rec.el) || $scope[0] === rec.el)) { return; }
            try {
                var cd = rec.iti.getSelectedCountryData();
                var name = $(rec.el).attr('name') || '';
                var national = (rec.el.value || '').replace(/\D/g, '');
                rec.el.value = national;
                if (name && name.indexOf('[]') === -1) {
                    var codeName = name + '_code';
                    var $code = $('[name="' + codeName + '"]');
                    if ($code.length && cd && cd.dialCode) { $code.val('+' + cd.dialCode); }
                }
            } catch (e) {}
        });
    }

    /* ---------------- Select2 ---------------- */
    $('.cv2-select').not('.cv2-modal-select').filter(function () {
        return $(this).closest('.cv2-filters').length === 0;
    }).each(function () {
        try { $(this).select2({ width: '100%', placeholder: $(this).find('option:first').text() }); } catch (e) {}
    });
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

    /* ---------------- daterangepicker (work experience) ---------------- */
    if ($.fn.daterangepicker) {
        $('.cv2-daterange').each(function () {
            var $inp = $(this);
            $inp.daterangepicker({ autoUpdateInput: false, locale: { format: 'DD/MM/YYYY', cancelLabel: 'Clear' } });
            $inp.on('apply.daterangepicker', function (ev, picker) {
                // ASCII " - " separator — controller explode(' - ') + d/m/Y parse.
                $inp.val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $inp.on('cancel.daterangepicker', function () { $inp.val(''); });
        });
    }

    /* ---------------- E5 same-as-permanent ---------------- */
    $('#cv2SameAsPermanent').on('change', function () {
        var on = $(this).is(':checked');
        $('#cv2PresentWrap').toggle(!on);
        if (on) {
            $('[name="present_address"]').val($('[name="permanent_address"]').val());
            $('[name="present_addr_postal_code"]').val($('[name="permanent_addr_postal_code"]').val());
            Toast.fire({ icon: 'info', title: 'Present address copied from permanent.' });
        }
    });

    /* ---------------- E3 bank repeater (exactly one primary) ---------------- */
    function bankOptionsHtml() {
        var $first = $('#cv2BankWrap .cv2-bank-row select[name="bank_id[]"]').first();
        return $first.length ? $first.html()
            : '<option value="">Choose bank</option>';
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
    });
    $('#cv2BankWrap').on('click', '.cv2-remove', function () {
        if ($('#cv2BankWrap .cv2-bank-row').length <= 1) {
            Toast.fire({ icon: 'error', title: 'At least one bank account is required.' });
            return;
        }
        $(this).closest('.cv2-bank-row').remove();
    });
    // Renumber primary radios to row index so it aligns with the bank_id[] array.
    function renumberBankPrimary() {
        $('#cv2BankWrap .cv2-bank-row').each(function (i) {
            $(this).find('input[name="primary_bank"]').val(i);
        });
    }

    /* ---------------- Emergency contact repeater ---------------- */
    $('#cv2AddPerson').on('click', function () {
        var $clone = $('#cv2PersonWrap .cv2-repeat-row').first().clone();
        $clone.find('input').each(function () {
            this.value = '';
            // reset intl markers so the clone re-inits cleanly
            this.removeAttribute('data-iti-done');
            $(this).removeClass('iti__tel-input');
        });
        // strip any intl wrapper the clone copied
        $clone.find('.iti').each(function () {
            var $tel = $(this).find('input[data-intl-phone="1"]');
            $(this).replaceWith($tel);
        });
        if ($clone.find('.cv2-remove').length === 0) {
            $clone.prepend('<button type="button" class="cv2-remove" title="Remove"><i class="bi bi-x-lg"></i></button>');
        }
        var $added = $clone.appendTo('#cv2PersonWrap');
        initAllPhones($added);
    });
    $('#cv2PersonWrap').on('click', '.cv2-remove', function () { $(this).closest('.cv2-repeat-row').remove(); });

    /* ---------------- status_type / status conditionals ---------------- */
    function syncStatusType() {
        var st = $('input[name="status_type"]:checked').val();
        $('[data-st="On Leave"]').toggle(st === 'On Leave');
        $('[data-st="Voluntary Exit"]').toggle(st === 'Voluntary Exit');
    }
    $(document).on('change', 'input[name="status_type"]', syncStatusType);
    if ($('input[name="status_type"]').length) { syncStatusType(); }

    function syncStatus() {
        var v = $('#cv2Status').val();
        $('#cv2StatusTypeWrap').toggle(v === 'Inactive');
        $('#cv2BlacklistWrap').toggle(v === 'Blacklisted');
        if (v === 'Inactive') { syncStatusType(); }
    }
    $('#cv2Status').on('change', syncStatus);
    if ($('#cv2Status').length) { syncStatus(); }

    $(document).on('change', 'input[name="set_reminder"]', function () {
        $('#cv2ReminderDays').toggle($('input[name="set_reminder"]:checked').val() === 'Yes');
    });

    /* ---------------- legal-case conditional (work exp modal) ---------------- */
    $(document).on('change', 'input[name="previous_legal_case"]', function () {
        $('[data-legal="Yes"]').toggle($('input[name="previous_legal_case"]:checked').val() === 'Yes');
    });

    /* ---------------- vehicle change toggle (edit) ---------------- */
    $('#cv2ChangeVehicle').on('change', function () {
        $('#cv2VehicleChangeWrap').toggle($(this).is(':checked'));
    });

    /* =====================================================================
       CREATE / UPDATE (multipart)
       ===================================================================== */
    function submitDriverForm($form) {
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
    $('#cv2DriverForm').on('submit', function (e) { e.preventDefault(); submitDriverForm($(this)); });
    $('#cv2EditForm').on('submit', function (e) { e.preventDefault(); submitDriverForm($(this)); });

    /* ---------------- Generic modal/inline AJAX form (serialize) ---------------- */
    function submitSerialized($form, hideModalSel) {
        preparePhones($form);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Saved.' });
                if (hideModalSel) { $(hideModalSel).modal('hide'); }
                setTimeout(function () { window.location.reload(); }, 900);
            },
            error: handleAjaxError
        });
    }
    function submitMultipart($form) {
        clearValidationErrors($form);
        var fd = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: fd,
            processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Saved.' });
                setTimeout(function () { window.location.reload(); }, 900);
            },
            error: handleAjaxError
        });
    }

    $('#cv2WorkExpForm').on('submit', function (e) { e.preventDefault(); submitSerialized($(this), '#cv2WorkExpModal'); });
    $('#cv2AssetForm').on('submit',   function (e) { e.preventDefault(); submitSerialized($(this), '#cv2AssetModal'); });
    $('#cv2ExitForm').on('submit',    function (e) { e.preventDefault(); submitSerialized($(this), null); });
    $('#cv2ActivityForm').on('submit',function (e) { e.preventDefault(); submitSerialized($(this), null); });
    $('#cv2DocForm').on('submit',     function (e) { e.preventDefault(); submitMultipart($(this)); });

    /* ---------------- Asset revoke ---------------- */
    $(document).on('click', '.cv2-revoke-asset', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Revoke this asset?', input: 'text', inputLabel: 'Revoke reason',
            inputPlaceholder: 'Reason', showCancelButton: true, confirmButtonText: 'Revoke', confirmButtonColor: '#ea0027',
            inputValidator: function (v) { if (!v) { return 'Reason is required.'; } }
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post($('#cv2AssetForm').data('revoke-url'), {
                employeeasset_id: id, revoke_date: new Date().toISOString().slice(0, 10), revoke_reason: r.value
            }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Revoked.' });
                setTimeout(function () { window.location.reload(); }, 900);
            }).fail(handleAjaxError);
        });
    });

    /* ---------------- Document delete ---------------- */
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

    /* ---------------- List delete (driver) ---------------- */
    $(document).on('click', '.cv2-del-driver', function () {
        var id = $(this).data('id');
        var url = $(this).data('url');
        Swal.fire({ title: 'Delete this driver?', text: 'This cannot be undone.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete' })
            .then(function (r) {
                if (!r.isConfirmed) { return; }
                $.post(url, { id: id }, function (res) {
                    Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                    setTimeout(function () { window.location.reload(); }, 900);
                }).fail(handleAjaxError);
            });
    });

    /* ---------------- D6: client-side file size pre-check (before AJAX) ---- */
    $(document).on('change', 'input[type="file"]', function () {
        var MAX = 2 * 1024 * 1024; // 2 MB
        Array.prototype.forEach.call(this.files, function (f) {
            if (f.size > MAX) {
                Toast.fire({ icon: 'warning', title: '"' + f.name + '" exceeds 2 MB and will be rejected by the server.' });
            }
        });
    });

    /* ---------------- E1 letter seen-status (post then open) ---------------- */
    $(document).on('click', '.cv2-letter-link', function (e) {
        var $a = $(this);
        var url = $a.data('seen-url');
        var payload = { contact_id: $a.data('contact-id'), type: $a.data('letter-type'), seen_status: 'Yes' };
        if (url) { $.post(url, payload).always(function () {}); }
        // allow default navigation (target=_blank) to proceed
    });
});
