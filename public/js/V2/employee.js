/* =====================================================================
   SR Logistics — Employee Module V2 (Gate 2 — live AJAX wiring)
   External JS only (SD-1). jQuery + Select2 + intl-tel-input + SweetAlert2.
   All form submits via $.ajax (SD-3). Toast.fire for notifications (SD-7).
   Validation errors as field-error spans below the field (SD-4).
   intl-tel getNumber()/dial codes written back before serialize (SD-13).
   Mirrors public/js/V2/customer.js patterns.
   version: 2.1
   ===================================================================== */
$(function () {
    'use strict';

    var CSRF = $('meta[name="csrf-token"]').attr('content');
    var hasSwal = (typeof Swal !== 'undefined');

    /* SD-7 — Toast mixin (defined once per file) */
    var Toast = hasSwal ? Swal.mixin({
        toast: true, position: 'top', showConfirmButton: false,
        timer: 3000, timerProgressBar: true,
        didOpen: function (t) {
            t.addEventListener('mouseenter', Swal.stopTimer);
            t.addEventListener('mouseleave', Swal.resumeTimer);
        }
    }) : { fire: function () {} };

    /* ---- AJAX defaults: CSRF + JSON accept on every request ---- */
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });

    /* ===============================================================
     | Letter "seen" auto-post (standalone joining/exit letter pages)
     | <body data-letter-seen="1" data-letter-type=".." data-contact-id=.. data-seen-url=..>
     | =============================================================== */
    (function () {
        var $body = $('body[data-letter-seen="1"]');
        if (!$body.length) { return; }
        var url = $body.data('seen-url');
        if (!url) { return; }
        $.ajax({
            url: url, method: 'POST',
            data: {
                contact_id: $body.data('contact-id'),
                type: $body.data('letter-type'),
                seen_status: 1
            }
        });
    })();

    /* ===============================================================
     | SD-4 — Validation error helpers
     | =============================================================== */
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

    function showValidationErrors(errors, $scope) {
        clearValidationErrors($scope);
        if (!errors) { return; }
        $.each(errors, function (field, messages) {
            var msg = Array.isArray(messages) ? messages[0] : messages;
            var $input = errorTargets(field);
            if ($scope && $input.length) { $input = $input.filter(function () { return $.contains($scope[0], this) || $scope[0] === this; }); }
            if ($input.length) {
                var $field = $input.first().closest('.cv2-field');
                var $span = $('<span class="text-danger small d-block mt-1 field-error"></span>').text(msg);
                if ($field.length) { $field.append($span); }
                else { $span.insertAfter($input.first()); }
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
        if (j.data && typeof j.data === 'object' && !Array.isArray(j.data)) { return j.data; }
        if (j.errors) { return j.errors; }
        return null;
    }

    function handleAjaxError(xhr, $scope) {
        if (xhr.status === 422) {
            var errs = extractErrors(xhr);
            if (errs) { showValidationErrors(errs, $scope); }
            var m = (xhr.responseJSON || {}).message;
            if (m) { Toast.fire({ icon: 'error', title: m }); }
        } else {
            var sm = (xhr.responseJSON || {}).message;
            Toast.fire({ icon: 'error', title: sm || 'Something went wrong.' });
        }
    }

    /* ===============================================================
     | intl-tel-input registry (SD-13)
     | =============================================================== */
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
        // Styled blades use [data-intl-phone="1"]; the shared wrapper rows use .telinput.
        (scope ? $(scope) : $(document)).find('input[data-intl-phone="1"], input.telinput').each(function () { initPhone(this); });
    }
    initAllPhones();

    // Before serialize: write national number back + mirror dial code into paired *_code field.
    function writePhoneNumbers($scope) {
        itiMap.forEach(function (rec) {
            if ($scope && !($.contains($scope[0], rec.el) || $scope[0] === rec.el)) { return; }
            try {
                var iti = rec.iti;
                var cd = iti.getSelectedCountryData();
                var dial = (cd && cd.dialCode) ? ('+' + cd.dialCode) : '';
                // keep national 10-digit number in the input (backend wants 10 digits + code)
                var national = '';
                if (typeof iti.getNumber === 'function') {
                    var full = iti.getNumber() || '';
                    national = full.replace(/^\+/, '');
                    if (cd && cd.dialCode && national.indexOf(cd.dialCode) === 0) {
                        national = national.substring(cd.dialCode.length);
                    }
                }
                if (national) { rec.el.value = national; }
                var name = $(rec.el).attr('name') || '';
                var $row = $(rec.el).closest('.cv2-repeat-row, .contact-person');
                if ($row.length) {
                    // styled blade rows use cv2-cp-phcode/wacode; wrapper rows use contact_person_*_code[] / .phone_code
                    if (name.indexOf('whatsapp') > -1) {
                        $row.find('.cv2-cp-wacode, [name="contact_person_whatsapp_code[]"]').val(dial);
                    } else if (name.indexOf('phone') > -1) {
                        $row.find('.cv2-cp-phcode, [name="contact_person_ph_code[]"]').val(dial);
                    }
                } else {
                    // main employee phone / whatsapp
                    if (rec.el.id === 'cv2MainPhone') { $('#cv2PhoneCode').val(dial); }
                    if (rec.el.id === 'cv2MainWhatsapp') { $('#cv2WhatsappCode').val(dial); }
                }
            } catch (e) {}
        });
    }

    /* ===============================================================
     | Select2 (form selects + modal selects with dropdownParent)
     | =============================================================== */
    if ($.fn.select2) {
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
    }

    /* ===============================================================
     | State -> City cascade (embedded data-cities JSON on each option)
     | =============================================================== */
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

    /* ===============================================================
     | daterangepicker — generic (en-dash) + work-exp (hyphen ' - ')
     | =============================================================== */
    if ($.fn.daterangepicker) {
        $('.cv2-daterange').each(function () {
            var $inp = $(this);
            $inp.daterangepicker({ autoUpdateInput: false, locale: { format: 'DD/MM/YYYY', cancelLabel: 'Clear' } });
            $inp.on('apply.daterangepicker', function (ev, picker) {
                $inp.val(picker.startDate.format('DD/MM/YYYY') + ' – ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $inp.on('cancel.daterangepicker', function () { $inp.val(''); });
        });
        // Work-experience duration MUST use ' - ' (hyphen-minus) separator.
        $('.cv2-daterange-hyphen').each(function () {
            var $inp = $(this);
            $inp.daterangepicker({ maxDate: moment(), autoUpdateInput: false, locale: { format: 'DD/MM/YYYY', cancelLabel: 'Clear' } });
            $inp.on('apply.daterangepicker', function (ev, picker) {
                $inp.val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $inp.on('cancel.daterangepicker', function () { $inp.val(''); });
        });
    }

    /* ===============================================================
     | Work Type / Service Type conditional show-hide
     | =============================================================== */
    function syncServiceType() {
        var st = $('input[name="service_type"]:checked').val();
        $('.cv2-cond[data-st="Technical"]').toggle(st === 'Technical');
    }
    function syncWorkType() {
        var v = $('input[name="workType"]:checked').val();
        $('.cv2-cond[data-wt]').hide();
        if (v) { $('.cv2-cond[data-wt="' + v + '"]').show(); }
        syncServiceType();
    }
    $(document).on('change', 'input[name="workType"]', syncWorkType);
    $(document).on('change', 'input[name="service_type"]', syncServiceType);
    if ($('[data-wt]').length) { syncWorkType(); }

    /* ---- Provident Fund number toggle ---- */
    $(document).on('change', 'input[name="providentFund"]', function () {
        $('#cv2PfNoWrap').toggle($('input[name="providentFund"]:checked').val() === 'yes');
    });

    /* ---- Status -> blacklist reason toggle ---- */
    $('#cv2Status').on('change', function () { $('#cv2BlacklistWrap').toggle($(this).val() === 'Blacklisted'); });

    /* ---- E5 same-as-permanent address copy (actually copies values) ---- */
    $('#cv2SameAddr').on('change', function () {
        var on = $(this).is(':checked');
        $('#cv2PresentWrap').toggle(!on);
        if (on) {
            $('[name="present_address"]').val($('[name="permanent_address"]').val());
            $('[name="present_addr_postal_code"]').val($('[name="permanent_addr_postal_code"]').val());
            $('[name="present_addr_additional_info"]').val($('[name="permanent_addr_additional_info"]').val());
            // state + cascade city
            var permState = $('[name="permanent_addr_state_id"]').val();
            var permCity = $('[name="permanent_addr_city_id"]').val();
            var $presState = $('[name="present_addr_state_id"]');
            $presState.val(permState);
            $('#cv2PresentCity').data('old', permCity);
            populateCities($presState);
            if ($.fn.select2) { try { $presState.trigger('change.select2'); } catch (e) {} }
            Toast.fire({ icon: 'success', title: 'Present address copied from permanent.' });
        }
    });

    /* ---- Asset issue: asset_type -> filter hint ---- */
    $('#cv2AssetType').on('change', function () {
        $('#cv2AssetHint').text($(this).val() ? 'Showing available ' + $(this).val() + ' assets' : '');
    });

    /* ===============================================================
     | Emergency-contact repeater (fetch fresh row from wrapper endpoint)
     | =============================================================== */
    var personIndex = $('#cv2PersonWrap .cv2-repeat-row').length;
    $(document).on('click', '#cv2AddPerson', function () {
        var url = $('#cv2EmployeeForm, #cv2EditForm').filter('[data-person-wrapper-url]').data('person-wrapper-url');
        var idx = personIndex++;
        if (url) {
            $.post(url, { rowindex: idx }, function (res) {
                var html = (res && res.data) ? res.data : (typeof res === 'string' ? res : null);
                if (html) {
                    var $row = $(html).appendTo('#cv2PersonWrap');
                    initAllPhones($row);
                    if ($.fn.select2) { try { $row.find('.cv2-modal-select, select.select2').select2({ width: '100%' }); } catch (e) {} }
                }
            }).fail(function () { Toast.fire({ icon: 'error', title: 'Could not add row.' }); });
        }
    });
    $(document).on('click', '#cv2PersonWrap .cv2-remove, #cv2PersonWrap .close-sec', function () {
        $(this).closest('.cv2-repeat-row, .contact-person').remove();
    });

    /* ===============================================================
     | Employee CREATE / UPDATE (multipart via FormData)
     | =============================================================== */
    function submitMainForm($form, redirectKey) {
        writePhoneNumbers($form);
        clearValidationErrors($form);
        var fd = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: fd,
            processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: (res && res.message) || 'Saved.' });
                var url = (res && res.redirect) || $form.data(redirectKey);
                setTimeout(function () { if (url) { window.location.href = url; } else { window.location.reload(); } }, 1000);
            },
            error: function (xhr) { handleAjaxError(xhr, $form); }
        });
    }
    $('#cv2EmployeeForm').on('submit', function (e) { e.preventDefault(); submitMainForm($(this), 'index-url'); });
    $('#cv2EditForm').on('submit', function (e) { e.preventDefault(); submitMainForm($(this), 'show-url'); });

    /* ===============================================================
     | Generic modal / inline form submit (serialize) -> reload on success
     | =============================================================== */
    function submitModalForm($form, $modal) {
        writePhoneNumbers($form);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: (res && res.message) || 'Saved.' });
                if ($modal && $modal.length) { $modal.modal('hide'); }
                setTimeout(function () { window.location.reload(); }, 900);
            },
            error: function (xhr) { handleAjaxError(xhr, $form); }
        });
    }

    $('#cv2WorkExpForm').on('submit', function (e) { e.preventDefault(); submitModalForm($(this), $('#cv2WorkExpModal')); });
    $('#cv2SalaryForm').on('submit', function (e) { e.preventDefault(); submitModalForm($(this), $('#cv2SalaryModal')); });
    $('#cv2AssetForm').on('submit', function (e) { e.preventDefault(); submitModalForm($(this), $('#cv2AssetModal')); });
    $('#cv2RevokeForm').on('submit', function (e) { e.preventDefault(); submitModalForm($(this), $('#cv2RevokeModal')); });
    $('#cv2ExitForm').on('submit', function (e) { e.preventDefault(); submitModalForm($(this), null); });
    $('#cv2ActivityForm').on('submit', function (e) { e.preventDefault(); submitModalForm($(this), null); });

    /* Revoke modal — capture which employee-asset id is being revoked */
    $(document).on('click', '.cv2-revoke-asset', function () {
        $('#cv2RevokeAssetId').val($(this).data('id'));
    });

    /* ===============================================================
     | DOCUMENTS — upload (multipart) + delete (Swal confirm)
     | =============================================================== */
    $('#cv2DocForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        clearValidationErrors($form);
        var fd = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: fd,
            processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: (res && res.message) || 'Uploaded.' });
                var url = (res && res.redirect) || $form.data('list-url');
                setTimeout(function () { if (url) { window.location.href = url; } else { window.location.reload(); } }, 900);
            },
            error: function (xhr) { handleAjaxError(xhr, $form); }
        });
    });

    $(document).on('click', '.cv2-del-doc', function () {
        var id = $(this).data('id');
        var deleteUrl = $('#cv2DocForm').data('delete-url');
        if (!deleteUrl) { return; }
        Swal.fire({
            title: 'Delete this document?', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post(deleteUrl, { id: id }, function (res) {
                Toast.fire({ icon: 'success', title: (res && res.message) || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 800);
            }).fail(handleAjaxError);
     
        });
    });
});
