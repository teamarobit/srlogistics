/* =====================================================================
   SR Logistics — Load Vendor (Broker) Module V2 (Gate 2 — live AJAX)
   External JS only (SD-1). jQuery + Select2 + intl-tel-input + SweetAlert2.
   All form submits via $.ajax (SD-3). Toast.fire for notifications (SD-7).
   Validation errors as field-error spans below the field (SD-4).
   intl-tel getNumber() written back before serialize (SD-13).
   ===================================================================== */
$(function () {
    'use strict';

    var CSRF = $('meta[name="csrf-token"]').attr('content');

    /* SD-7 — Toast mixin (defined once per file) */
    var Toast = Swal.mixin({
        toast: true, position: 'top', showConfirmButton: false,
        timer: 3000, timerProgressBar: true,
        didOpen: function (t) {
            t.addEventListener('mouseenter', Swal.stopTimer);
            t.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });

    /* ---- SD-4 validation error helpers ---- */
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
                if ($field.length) { $field.append($span); }
                else { $span.insertAfter($input); }
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
            Toast.fire({ icon: 'error', title: 'Something went wrong.' });
        }
    }

    /* ---- intl-tel-input registry (SD-13) ---- */
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

    function writePhoneNumbers($scope) {
        itiMap.forEach(function (rec) {
            if (!$scope || $.contains($scope[0], rec.el) || $scope[0] === rec.el) {
                try {
                    var num = rec.iti.getNumber();
                    if (num) { rec.el.value = num; }
                    var cd = rec.iti.getSelectedCountryData();
                    var $row = $(rec.el).closest('.cv2-repeat-row');
                    if ($row.length && cd && cd.dialCode) {
                        var nm = $(rec.el).attr('name') || '';
                        if (nm.indexOf('phone') > -1) { $row.find('.cv2-cp-phcode').val('+' + cd.dialCode); }
                        if (nm.indexOf('whatsapp') > -1) { $row.find('.cv2-cp-wacode').val('+' + cd.dialCode); }
                    }
                } catch (e) {}
            }
        });
    }

    /* ---- Select2 init (form selects + modal selects with dropdownParent) ---- */
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

    /* ---- State -> City cascade ---- */
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
     | CREATE / UPDATE (multipart via FormData)
     | =============================================================== */
    function submitVendorForm($form, redirectKey) {
        writePhoneNumbers($form);
        clearValidationErrors($form);
        var fd = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: fd,
            processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Saved.' });
                var url = $form.data(redirectKey);
                setTimeout(function () { if (url) { window.location.href = url; } else { window.location.reload(); } }, 1000);
            },
            error: handleAjaxError
        });
    }
    $('#cv2LoadVendorForm').on('submit', function (e) { e.preventDefault(); submitVendorForm($(this), 'index-url'); });
    $('#cv2EditForm').on('submit', function (e) { e.preventDefault(); submitVendorForm($(this), 'show-url'); });

    /* ---- Contact-person repeater (create / edit) via wrapper endpoint ---- */
    var personIndex = $('#cv2PersonWrap .cv2-repeat-row').length;
    $('#cv2AddPerson').on('click', function () {
        var url = $('#cv2LoadVendorForm, #cv2EditForm').filter('[data-person-wrapper-url]').data('person-wrapper-url');
        var idx = personIndex++;
        if (url) {
            $.post(url, { rowindex: idx }, function (res) {
                if (res && res.data) {
                    var $row = $(res.data).appendTo('#cv2PersonWrap');
                    initAllPhones($row);
                }
            }).fail(function () { Toast.fire({ icon: 'error', title: 'Could not add row.' }); });
        }
    });
    $('#cv2PersonWrap').on('click', '.cv2-remove', function () { $(this).closest('.cv2-repeat-row').remove(); });

    /* ---- Status -> blacklist reason toggle (edit) ---- */
    $('#cv2Status').on('change', function () { $('#cv2BlacklistWrap').toggle($(this).val() === 'Blacklisted'); });

    /* ===============================================================
     | LIST — delete (index page) — generic contact delete
     | =============================================================== */
    $(document).on('click', '.cv2-del-vendor', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this load vendor?', text: 'This cannot be undone.', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post('/contacts/v2/load-vendors/delete', { id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 900);
            }).fail(handleAjaxError);
        });
    });

    /* ===============================================================
     | CUSTOMERS page — standalone contact-person modal (add / edit / delete)
     | DISABLED: the Load Vendor "Customers" tab was NOT developed in V1
     | (static mock, no add button). The add/edit/delete UI is commented out
     | in customers.blade.php; this dynamic block is disabled to match.
     | To re-enable: uncomment this block + the button/modal in the blade.
     |
     | $('#cv2AddPersonBtn').on('click', function () { ... });
     | $(document).on('click', '.cv2-edit-person', function () { ... });
     | $('#cv2PersonModalForm').on('submit', function (e) { ... });
     | $(document).on('click', '.cv2-del-person', function () { ... });
     | =============================================================== */

    /* ===============================================================
     | LOCATIONS page — AJAX list + filter + save + delete
     | =============================================================== */
    function loadLocations() {
        var $card = $('#cv2LocationsCard');
        if (!$card.length) { return; }
        var url = $card.data('list-url');
        var type = $('#cv2LocFilter').val();
        $.get(url, { location_type: type }, function (html) {
            $('#cv2LocationsList').html(html);
        }).fail(function () {
            $('#cv2LocationsList').html('<div class="text-center cv2-empty" style="padding:24px;">Failed to load.</div>');
        });
    }
    if ($('#cv2LocationsCard').length) { loadLocations(); }
    $('#cv2LocFilter').on('change', loadLocations);

    $(document).on('change', '#cv2RouteType input[name="route_type"]', function () {
        var v = $(this).val();
        $('.cv2-cond[data-rt]').hide();
        $('.cv2-cond[data-rt="' + v + '"]').show();
    });
    $(document).on('change', '#cv2LocType input[name="location_type"]', function () {
        var v = $(this).val();
        $('.cv2-cond[data-lt="Loading"]').toggle(v === 'Loading' || v === 'Both');
        $('.cv2-cond[data-lt="Unloading"]').toggle(v === 'Unloading' || v === 'Both');
    });
    $(document).on('change', '#cv2BroneBy input[name="brone_by"]', function () {
        $('.cv2-cond[data-bb="mixed"]').toggle($(this).val() === 'mixed');
    });

    $('#cv2LocationForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        writePhoneNumbers($form);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Location saved.' });
                $('#cv2LocationModal').modal('hide');
                $form[0].reset();
                $('.cv2-cond').hide();
                loadLocations();
            },
            error: handleAjaxError
        });
    });

    $(document).on('click', '.cv2-del-location', function () {
        var id = $(this).data('location-id');
        Swal.fire({
            title: 'Delete this location?', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post($('#cv2LocationForm').attr('action').replace('/save', '/delete'), { location_id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                loadLocations();
            }).fail(handleAjaxError);
        });
    });

    /* ===============================================================
     | DOCUMENTS page — upload + delete
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
                Toast.fire({ icon: 'success', title: res.message || 'Uploaded.' });
                var url = $form.data('list-url');
                setTimeout(function () { if (url) { window.location.href = url; } else { window.location.reload(); } }, 900);
            },
            error: handleAjaxError
        });
    });
    $(document).on('click', '.cv2-del-doc', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this document?', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post($('#cv2DocForm').attr('action').replace('/save', '/delete'), { id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 900);
            }).fail(handleAjaxError);
        });
    });

    /* ===============================================================
     | ACTIVITY page — add note
     | =============================================================== */
    $('#cv2ActivityForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Note saved.' });
                var url = $form.data('list-url');
                setTimeout(function () { if (url) { window.location.href = url; } else { window.location.reload(); } }, 900);
            },
            error: handleAjaxError
        });
    });
});
