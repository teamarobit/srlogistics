/* =====================================================================
   SR Logistics — Customer Module V2 (Gate 2 — live AJAX wiring)
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

    /* ---- AJAX defaults: CSRF + JSON accept on every request ---- */
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
    });

    /* ===============================================================
     | SD-4 — Validation error helpers
     | Accepts either a {field: [msg]} map (Laravel errors()) OR the
     | controller's `data` bag which may carry dotted/underscored keys.
     | =============================================================== */
    function clearValidationErrors(scope) {
        (scope ? $(scope) : $(document)).find('.field-error').remove();
    }

    function errorTargets(field) {
        // Try exact name, array name name[idx] -> name[], and underscore keys.
        var $t = $('[name="' + field + '"]');
        if ($t.length) { return $t; }

        // dotted key e.g. contact_person_phone.0  ->  name="contact_person_phone[0]"
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

        // underscore-suffixed key e.g. coattachtype_0 / coattachments_0
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
                // Skip if this field already shows an error (e.g. a date range
                // backed by two hidden start/end inputs) — one message per field.
                if ($field.length && $field.find('.field-error').length) { return; }
                var $span = $('<span class="text-danger small d-block mt-1 field-error"></span>').text(msg);
                if ($field.length) { $field.append($span); }
                else { $span.insertAfter($input); }
            }
        });
        var $first = $('.field-error').first();
        if ($first.length) {
            // Scroll inside an open modal if present, else the page.
            var $modal = $first.closest('.modal');
            if ($modal.length && $modal.hasClass('show')) {
                $modal.animate({ scrollTop: $modal.scrollTop() + $first.position().top - 80 }, 300);
            } else {
                $('html, body').animate({ scrollTop: $first.offset().top - 120 }, 300);
            }
        }
    }

    // The controllers return validation under either `errors` or `data`.
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

    /* ===============================================================
     | intl-tel-input registry (SD-13) — keep references for getNumber()
     | =============================================================== */
    var itiMap = [];   // [{el, iti}]
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
        (scope ? $(scope) : $(document)).find('input[data-intl-phone="1"]').each(function () {
            initPhone(this);
        });
    }
    initAllPhones();

    // Before serialize: write the NATIONAL significant number (digits only) into
    // each phone input. The backend validates phone/whatsapp as digits:10 and
    // stores the dial code separately in ph_prefix, so writing the full E.164
    // value (e.g. +919876543210) made valid numbers fail the digits:10 rule.
    function writePhoneNumbers($scope) {
        itiMap.forEach(function (rec) {
            if (!$scope || $.contains($scope[0], rec.el) || $scope[0] === rec.el) {
                try {
                    var num = rec.iti.getNumber();   // E.164, e.g. +919876543210
                    var cd = rec.iti.getSelectedCountryData();
                    if (num) {
                        var national = num;
                        if (national.charAt(0) === '+') {           // E.164 -> strip dial code
                            national = national.substring(1);
                            if (cd && cd.dialCode && national.indexOf(cd.dialCode) === 0) {
                                national = national.substring(cd.dialCode.length);
                            }
                        }
                        national = national.replace(/\D/g, '');
                        rec.el.value = national;
                    }
                    // mirror dial code into the paired hidden code input if present
                    var $row = $(rec.el).closest('.cv2-repeat-row');
                    if ($row.length && cd && cd.dialCode) {
                        if ($(rec.el).attr('name') && $(rec.el).attr('name').indexOf('phone') > -1) {
                            $row.find('.cv2-cp-phcode').val(cd.dialCode);
                        }
                        if ($(rec.el).attr('name') && $(rec.el).attr('name').indexOf('whatsapp') > -1) {
                            $row.find('.cv2-cp-wacode').val(cd.dialCode);
                        }
                    }
                } catch (e) {}
            }
        });
    }

    /* ===============================================================
     | Select2 init (form selects + modal selects with dropdownParent)
     | =============================================================== */
    $('.cv2-select').not('.cv2-modal-select').filter(function () {
        return $(this).closest('.cv2-filters').length === 0;
    }).each(function () {
        try { $(this).select2({ width: '100%', placeholder: $(this).find('option:first').text() }); } catch (e) {}
    });

    /* Filter bar — searchable city dropdown (Select2 with search box) */
    var $filterCity = $('#cv2FilterCity');
    if ($filterCity.length) {
        try {
            $filterCity.select2({
                width: '240px',
                placeholder: $filterCity.data('placeholder') || 'All Cities',
                allowClear: true
            });
        } catch (e) {}
    }

    $('.cv2-modal').on('shown.bs.modal', function () {
        var $modal = $(this);
        $modal.find('.cv2-modal-select').each(function () {
            if ($(this).hasClass('select2-hidden-accessible')) { return; }
            try {
                $(this).select2({ width: '100%', dropdownParent: $modal, placeholder: $(this).find('option:first').text() });
            } catch (e) {}
        });
        initAllPhones($modal);
    });

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
    // Do NOT auto-fire on load for edit pages (server already rendered the selected city).

    /* ===============================================================
     | daterangepicker on rate-chart ranges -> hidden start/end fields
     | =============================================================== */
    if ($.fn.daterangepicker) {
        $('.cv2-daterange').each(function () {
            var $inp = $(this);
            $inp.daterangepicker({ autoUpdateInput: false, locale: { format: 'DD/MM/YYYY', cancelLabel: 'Clear' } });
            $inp.on('apply.daterangepicker', function (ev, picker) {
                $inp.val(picker.startDate.format('DD/MM/YYYY') + ' – ' + picker.endDate.format('DD/MM/YYYY'));
                var startSel = $inp.data('start'), endSel = $inp.data('end');
                if (startSel) { $(startSel).val(picker.startDate.format('YYYY-MM-DD')); }
                if (endSel) { $(endSel).val(picker.endDate.format('YYYY-MM-DD')); }
            });
            $inp.on('cancel.daterangepicker', function () {
                $inp.val('');
                if ($inp.data('start')) { $($inp.data('start')).val(''); }
                if ($inp.data('end')) { $($inp.data('end')).val(''); }
            });
        });

        /* Single-date picker (contract / vehicle dates).
           DISPLAYS DD-MM-YYYY to the user, but SUBMITS YYYY-MM-DD via a hidden
           mirror field (backend date columns require YYYY-MM-DD). */
        $('.cv2-date').each(function () {
            var $inp = $(this);
            var dname = $inp.attr('name');
            var $hidden = $();
            if (dname) {
                $hidden = $('<input type="hidden">').attr('name', dname);
                $inp.removeAttr('name').after($hidden);
                $hidden.data('display', $inp);
                $inp.data('mirror', $hidden);
                var seed = $.trim($inp.val());
                if (seed) {
                    var ms = moment(seed, 'YYYY-MM-DD', true);
                    if (!ms.isValid()) { ms = moment(seed, 'DD-MM-YYYY', true); }
                    if (ms.isValid()) { $hidden.val(ms.format('YYYY-MM-DD')); $inp.val(ms.format('DD-MM-YYYY')); }
                }
            }
            var dpOpts = {
                singleDatePicker: true,
                autoUpdateInput: false,
                locale: { format: 'DD-MM-YYYY', cancelLabel: 'Clear' }
            };
            if (dname === 'start_date') { dpOpts.minDate = moment(); } // V1 parity: no past start date
            $inp.daterangepicker(dpOpts);
            $inp.on('apply.daterangepicker', function (ev, picker) {
                $inp.val(picker.startDate.format('DD-MM-YYYY'));
                $hidden.val(picker.startDate.format('YYYY-MM-DD'));
                if (dname === 'start_date') { calcCv2EndDate(); }
                if (dname === 'end_date')   { updateContractStatus(); }
            });
            $inp.on('cancel.daterangepicker', function () { $inp.val(''); $hidden.val(''); });
        });
    }

    /* ===============================================================
     | Customer CREATE / UPDATE (multipart via FormData)
     | =============================================================== */
    function submitCustomerForm($form, redirectKey) {
        writePhoneNumbers($form);
        clearValidationErrors($form);
        var fd = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Saved.' });
                var url = $form.data(redirectKey);
                setTimeout(function () { if (url) { window.location.href = url; } else { window.location.reload(); } }, 1000);
            },
            error: handleAjaxError
        });
    }

    $('#cv2CustomerForm').on('submit', function (e) {
        e.preventDefault();
        submitCustomerForm($(this), 'index-url');
    });
    $('#cv2EditForm').on('submit', function (e) {
        e.preventDefault();
        submitCustomerForm($(this), 'show-url');
    });

    /* ---- Contact-person repeater (create / edit) via wrapper endpoint ---- */
    var personIndex = $('#cv2PersonWrap .cv2-repeat-row').length;
    $('#cv2AddPerson').on('click', function () {
        var url = $('#cv2CustomerForm, #cv2EditForm').filter('[data-person-wrapper-url]').data('person-wrapper-url');
        var idx = personIndex++;
        if (url) {
            $.post(url, { rowindex: idx }, function (res) {
                if (res && res.data) {
                    var $row = $(res.data).appendTo('#cv2PersonWrap');
                    initAllPhones($row);
                    try { $row.find('.cv2-modal-select').select2({ width: '100%' }); } catch (e) {}
                }
            }).fail(function () { Toast.fire({ icon: 'error', title: 'Could not add row.' }); });
        } else {
            // fallback: clone first row
            var $clone = $('#cv2PersonWrap .cv2-repeat-row').first().clone();
            $clone.find('input').val('');
            $('#cv2PersonWrap').append($clone);
        }
    });
    $('#cv2PersonWrap').on('click', '.cv2-remove', function () { $(this).closest('.cv2-repeat-row').remove(); });

    /* Status -> blacklist reason toggle (edit) */
    $('#cv2Status').on('change', function () { $('#cv2BlacklistWrap').toggle($(this).val() === 'Blacklisted'); });

    /* Halting deduction checkbox -> show/hide halting charges field (REG-04) */
    $(document).on('change', '.cv2-halting-toggle', function () {
        $('.cv2-halting-wrap').toggle($(this).is(':checked'));
    });

    /* ===============================================================
     | Customer LIST — delete (index page)
     | =============================================================== */
    $(document).on('click', '.cv2-del-customer', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this customer?', text: 'This cannot be undone.', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post('/contacts/delete', { id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 900);
            }).fail(handleAjaxError);
        });
    });

    /* ===============================================================
     | Customer LIST — select-all checkbox (index page)
     | Header checkbox toggles every row checkbox; row changes keep the
     | header in sync (checked / unchecked / indeterminate).
     | =============================================================== */
    var $cv2CheckAll = $('#cv2CheckAll');
    if ($cv2CheckAll.length) {
        $cv2CheckAll.on('change', function () {
            $('.cv2-row-check').prop('checked', this.checked);
        });
        $(document).on('change', '.cv2-row-check', function () {
            var $rows = $('.cv2-row-check');
            var checked = $rows.filter(':checked').length;
            $cv2CheckAll.prop('checked', checked > 0 && checked === $rows.length);
            $cv2CheckAll.prop('indeterminate', checked > 0 && checked < $rows.length);
        });
    }

    /* ===============================================================
     | LOCATIONS tab — AJAX list load + filter + save + delete
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

    /* Location modal conditional fields */
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

    /* Capping must not exceed loading / unloading charge (parity with V1 validateCapping) */
    function cv2ValidateCapping() {
        var $f        = $('#cv2LocationForm');
        var loading   = parseFloat($f.find('input[name="loading_charge"]').val());
        var unloading = parseFloat($f.find('input[name="unloading_charge"]').val());
        var $cap      = $f.find('input[name="capping_amount"]');
        var capping   = parseFloat($cap.val());
        if (isNaN(capping)) { return; }
        var maxAllowed = null;
        if (!isNaN(loading) && !isNaN(unloading)) { maxAllowed = Math.min(loading, unloading); }
        else if (!isNaN(loading))   { maxAllowed = loading; }
        else if (!isNaN(unloading)) { maxAllowed = unloading; }
        else { return; }
        if (capping > maxAllowed) {
            Toast.fire({ icon: 'error', title: 'Capping amount cannot be greater than loading or unloading charge.' });
            $cap.val(maxAllowed);
        }
    }
    $(document).on('change blur',
        '#cv2LocationForm input[name="capping_amount"], #cv2LocationForm input[name="loading_charge"], #cv2LocationForm input[name="unloading_charge"]',
        cv2ValidateCapping);

    $('#cv2LocationForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        writePhoneNumbers($form);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Location saved.' });
                $('#cv2LocationModal').modal('hide');
                $form[0].reset();
                // Native reset clears the <select> value but Select2 keeps its
                // rendered selection — re-sync so city/route dropdowns show blank.
                $form.find('.cv2-modal-select').val('').trigger('change.select2');
                // Hide conditional fields revealed by the previous entry.
                $form.find('.cv2-cond').hide();
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
     | CONTRACT form (create) — type/reminder toggles + save
     | =============================================================== */
    // Auto-calc End Date from Start Date + Contract Type (parity with Contract create V1)
    function calcCv2EndDate() {
        var typeText = $('#cv2ContractType option:selected').text().trim();
        // start/end submit values live in the hidden mirrors (YYYY-MM-DD);
        // the visible inputs only display DD-MM-YYYY.
        var $endHidden  = $('input[type="hidden"][name="end_date"]');
        var $endDisplay = $endHidden.data('display');
        function setEnd(ymd) {
            $endHidden.val(ymd);
            if ($endDisplay && $endDisplay.length) {
                $endDisplay.val(ymd ? moment(ymd, 'YYYY-MM-DD').format('DD-MM-YYYY') : '');
            }
        }
        var startVal = $('input[type="hidden"][name="start_date"]').val();
        if (!startVal) { return; }
        var start = moment(startVal, 'YYYY-MM-DD');
        if (!start.isValid()) { return; }
        var end = start.clone();
        if      (typeText === 'Monthly')     { end.add(1, 'months').subtract(1, 'days'); }
        else if (typeText === 'Quarterly')   { end.add(3, 'months').subtract(1, 'days'); }
        else if (typeText === 'Half Yearly') { end.add(6, 'months').subtract(1, 'days'); }
        else if (typeText === 'Yearly')      { end.add(1, 'years').subtract(1, 'days'); }
        else { setEnd(''); updateContractStatus(); return; } // Trip Wise / Life Time / none = no end date (field hidden by data-when)
        setEnd(end.format('YYYY-MM-DD'));
        updateContractStatus();
    }

    // Derive Status (Active / Inactive / Life Time) from contract type + end date (V1 parity)
    function updateContractStatus() {
        var typeText = $('#cv2ContractType option:selected').text().trim();
        var $status  = $('#cv2ContractStatus');
        if (!$status.length) { return; }
        var status = 'Active';
        if (typeText === 'Life Time')      { status = 'Life Time'; }
        else if (typeText === 'Trip Wise') { status = 'Active'; }
        else {
            var endVal = $('input[type="hidden"][name="end_date"]').val();
            if (endVal) {
                status = moment(endVal, 'YYYY-MM-DD').isSameOrAfter(moment().startOf('day')) ? 'Active' : 'Inactive';
            }
        }
        $status.val(status);
    }

    function syncContractType() {
        var v = $('#cv2ContractType').val();
        $('[data-when="monthly"]').toggle(v === '1');
        $('[data-when="dated"]').toggle(v !== '6' && v !== '5');
        calcCv2EndDate();
        updateContractStatus();
    }
    $('#cv2ContractType').on('change', syncContractType);
    if ($('#cv2ContractType').length) { syncContractType(); }
    $('#cv2Reminder').on('change', function () { $('#cv2ReminderDays').toggle($(this).val() === 'Yes'); });

    $('#cv2ContractForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        clearValidationErrors($form);
        var fd = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: fd,
            processData: false, contentType: false,
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Contract saved.' });
                var url = $form.data('contracts-url');
                setTimeout(function () { if (url) { window.location.href = url; } }, 1000);
            },
            error: handleAjaxError
        });
    });

    /* CONTRACT list — delete (edit is a direct link to the edit page) */
    $(document).on('click', '.cv2-del-contract', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this contract?', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post('/contacts/v2/customers/contract/delete', { id: id, actmodelid: 46 }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 900);
            }).fail(handleAjaxError);
        });
    });

    /* ===============================================================
     | RATE CHART — dependent dropdowns + midpoints + vehicle rows + save
     | =============================================================== */
    var RATE_BASE = $('#cv2RateForm').data('routes-url');   // .../customers/contract

    function loadRateRoutes(contractId) {
        var $route = $('#cv2RateRoute');
        $route.empty().append(new Option('Choose route', '')).trigger('change.select2');
        if (!contractId || !RATE_BASE) { return; }
        $.get(RATE_BASE + '/' + contractId + '/routes', function (res) {
            if (res && res.routes) {
                res.routes.forEach(function (r) {
                    var o = new Option(r.name || ('Route #' + r.id), r.id);
                    o.setAttribute('data-midpoints', r.midpoints_count || 0);
                    $route.append(o);
                });
                $route.trigger('change.select2');
            }
        }).fail(handleAjaxError);
    }

    $('#cv2RateContract').on('change', function () {
        var $opt = $(this).find('option:selected');
        var status = $opt.data('status');
        var id = $(this).val();
        var self = this;
        if (status === 'Inactive') {
            Swal.fire({
                title: 'Contract is inactive', text: 'Do you still want to select this contract?',
                icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes, use it'
            }).then(function (r) {
                if (r.isConfirmed) { loadRateRoutes(id); }
                else { $(self).val('').trigger('change.select2'); loadRateRoutes(''); }
            });
        } else {
            loadRateRoutes(id);
        }
    });

    $('#cv2RateRoute').on('change', function () {
        var routeId = $(this).val();
        var $opt = $(this).find('option:selected');
        var midpoints = parseInt($opt.attr('data-midpoints'), 10) || 0;
        $('#cv2MidpointCount').val(midpoints);
        buildMidpointSections(midpoints);
        $('#cv2RateSource').empty().append(new Option('Choose source', '')).trigger('change.select2');
        $('#cv2RateDest').empty().append(new Option('Choose destination', '')).trigger('change.select2');
        $('#cv2AddContractPricingBtn, button[form="cv2RateForm"]').prop('disabled', false);
        if (!routeId || !RATE_BASE) { return; }

        var contactId = $('#cv2RateForm input[name="contact_id"]').val();
        $.get(RATE_BASE + '/' + routeId + '/points-setup', { contact_id: contactId }, function (res) {
            if (res && res.complete === false && res.missing && res.missing.length) {
                Swal.fire({
                    icon: 'warning', title: 'Location setup incomplete',
                    text: 'Configure customer Locations for: ' + res.missing.join(', ') + ' before adding a Rate Chart.'
                });
                $('#cv2RateRoute').val('').trigger('change.select2');
                $('button[form="cv2RateForm"]').prop('disabled', true);
                return;
            }
            // Populate source / destination from configured points.
            if (res && res.points) {
                var $src = $('#cv2RateSource').empty().append(new Option('Choose source', ''));
                (res.points.source || []).forEach(function (p) { $src.append(new Option(p.location_name, p.id)); });
                var $dst = $('#cv2RateDest').empty().append(new Option('Choose destination', ''));
                (res.points.destination || []).forEach(function (p) { $dst.append(new Option(p.location_name, p.id)); });
                $src.trigger('change.select2'); $dst.trigger('change.select2');
            }
        }).fail(handleAjaxError);
    });

    function buildMidpointSections(count) {
        var $wrap = $('#cv2MidpointSections');
        if (!$wrap.length) { return; }
        $wrap.empty();
        for (var i = 1; i <= count; i++) {
            $wrap.append(
                '<div class="cv2-veh-row" data-mp="' + i + '">' +
                '<div class="cv2-field"><label class="cv2-label">Midpoint ' + i + ' Type</label>' +
                '<select class="cv2-select cv2-modal-select cv2-mp-type" name="midpoint_type[' + i + ']" style="width:100%;">' +
                '<option value="">Type</option><option value="Loading">Loading</option><option value="Unloading">Unloading</option></select></div>' +
                '<div class="cv2-field cv2-mp-load" style="display:none;"><label class="cv2-label">Loading Point</label>' +
                '<select class="cv2-select cv2-modal-select" name="loading_midpoint[' + i + ']" style="width:100%;"><option value="">Select</option></select></div>' +
                '<div class="cv2-field cv2-mp-unload" style="display:none;"><label class="cv2-label">Unloading Point</label>' +
                '<select class="cv2-select cv2-modal-select" name="unloading_midpoint[' + i + ']" style="width:100%;"><option value="">Select</option></select></div>' +
                '</div>'
            );
        }
        $wrap.find('.cv2-modal-select').each(function () {
            try { $(this).select2({ width: '100%', dropdownParent: $('#cv2RateModal') }); } catch (e) {}
        });
    }

    // Midpoint type change -> show relevant select + load customer midpoint locations.
    $(document).on('change', '.cv2-mp-type', function () {
        var $row = $(this).closest('[data-mp]');
        var type = $(this).val();
        $row.find('.cv2-mp-load').toggle(type === 'Loading');
        $row.find('.cv2-mp-unload').toggle(type === 'Unloading');
        if (!type) { return; }
        var contactId = $('#cv2RateForm input[name="contact_id"]').val();
        $.post('/contacts/v2/customers/location/midpoints', { contact_id: contactId, type: type }, function (res) {
            if (res && res.data) {
                var $sel = type === 'Loading' ? $row.find('.cv2-mp-load select') : $row.find('.cv2-mp-unload select');
                $sel.empty().append(new Option('Select', ''));
                res.data.forEach(function (loc) { $sel.append(new Option(loc.location_name, loc.id)); });
                $sel.trigger('change.select2');
            }
        }).fail(handleAjaxError);
    });

    /* Vehicle pricing repeater (rate chart) */
    function rateVehTypeOptions() {
        var html = '<option value="">Type</option>';
        var data = [];
        try { data = JSON.parse($('#cv2VehTypeData').text() || '[]'); } catch (e) { data = []; }
        data.forEach(function (t) {
            html += '<option value="' + t.id + '" data-sizes=\'' + JSON.stringify(t.sizes || []) + '\'>' + t.name + '</option>';
        });
        return html;
    }
    function cv2VehRowHtml() {
        return '<div class="cv2-veh-row">' +
            '<div class="cv2-field"><label class="cv2-label">Vehicle Type</label><select class="cv2-select cv2-modal-select cv2-veh-type" name="vehicle_type_id[]" style="width:100%;">' + rateVehTypeOptions() + '</select></div>' +
            '<div class="cv2-field"><label class="cv2-label">Vehicle Size</label><select class="cv2-select cv2-modal-select" name="vehicletype_size_id[]" style="width:100%;"><option value="">Size</option></select></div>' +
            '<div class="cv2-field"><label class="cv2-label">Weight</label><input type="text" name="vehicletype_weight[]"></div>' +
            '<div class="cv2-field"><label class="cv2-label">Price (₹)</label><input type="text" name="vehicletype_price[]"></div>' +
            '<button type="button" class="cv2-remove" title="Remove vehicle"><i class="bi bi-x-lg"></i></button>' +
            '</div>';
    }
    $('#cv2AddVehRow').on('click', function () {
        var $row = $(cv2VehRowHtml()).appendTo('#cv2VehRows');
        $row.find('.cv2-modal-select').each(function () {
            try { $(this).select2({ width: '100%', dropdownParent: $('#cv2RateModal') }); } catch (e) {}
        });
    });
    $('#cv2VehRows').on('click', '.cv2-remove', function () { $(this).closest('.cv2-veh-row').remove(); });

    // Vehicle type -> size cascade (data-sizes on the selected option).
    $(document).on('change', '.cv2-veh-type, select[name="vehicle_type_id[]"]', function () {
        var $row = $(this).closest('.cv2-veh-row');
        var $size = $row.find('select[name="vehicletype_size_id[]"]');
        var sizes = [];
        try { sizes = JSON.parse($(this).find('option:selected').attr('data-sizes') || '[]'); } catch (e) { sizes = []; }
        $size.empty().append(new Option('Size', ''));
        sizes.forEach(function (s) { $size.append(new Option(s.name, s.id)); });
        $size.trigger('change.select2');
    });

    $('#cv2RateForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Rate chart saved.' });
                $('#cv2RateModal').modal('hide');
                var url = $form.data('ratechart-url');
                setTimeout(function () { if (url) { window.location.href = url; } else { window.location.reload(); } }, 1000);
            },
            error: handleAjaxError
        });
    });

    $(document).on('click', '.cv2-del-pricing', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this rate chart?', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) { return; }
            $.post('/contacts/v2/customers/contract/pricing/delete', { pricing_id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 900);
            }).fail(handleAjaxError);
        });
    });

    /* Rate chart per-row info actions -> generic info modal */
    function openInfo(title, bodyHtml) {
        $('#cv2InfoTitle').text(title);
        $('#cv2InfoBody').html(bodyHtml);
        $('#cv2InfoModal').modal('show');
    }
    $(document).on('click', '.cv2-pricing-labour', function () {
        var id = $(this).data('id');
        $.get('/contacts/v2/customers/contract-pricing/' + id + '/labour-charges', function (res) {
            if (!res || !res.success) { Toast.fire({ icon: 'error', title: 'No data.' }); return; }
            var rows = (res.data || []).map(function (d) {
                return '<tr><td>' + d.loading_point + '</td><td>' + d.unloading_point + '</td><td>' + d.paid_by + '</td><td>₹' + d.amount + '</td></tr>';
            }).join('');
            openInfo('Labour Charges', '<table class="cv2-table"><thead><tr><th>Loading Point</th><th>Unloading Point</th><th>Paid By</th><th>Amount</th></tr></thead><tbody>' + (rows || '<tr><td colspan="4" class="text-center">No data</td></tr>') + '</tbody></table>');
        }).fail(handleAjaxError);
    });
    $(document).on('click', '.cv2-pricing-vehicles', function () {
        var id = $(this).data('id');
        $.get('/contacts/v2/customers/contract-pricing/' + id + '/vehicles', function (res) {
            if (!res || !res.success) { Toast.fire({ icon: 'error', title: 'No data.' }); return; }
            var rows = (res.data || []).map(function (d) {
                return '<tr><td>' + d.size + '</td><td>₹' + d.freight + '</td></tr>';
            }).join('');
            openInfo('Vehicle Freight', '<table class="cv2-table"><thead><tr><th>Size</th><th>Freight</th></tr></thead><tbody>' + (rows || '<tr><td colspan="2" class="text-center">No data</td></tr>') + '</tbody></table>');
        }).fail(handleAjaxError);
    });
    $(document).on('click', '.cv2-pricing-history', function () {
        var id = $(this).data('id');
        $.get('/contacts/v2/customers/contract-pricing/' + id + '/history', function (res) {
            if (res && res.html) {
                $('#cv2InfoModalContent').html(res.html);
                $('#cv2InfoModal').modal('show');
            } else { Toast.fire({ icon: 'info', title: 'No history.' }); }
        }).fail(handleAjaxError);
    });

    /* ===============================================================
     | VEHICLES tab — AJAX list + save
     | =============================================================== */
    function loadVehicles() {
        var $list = $('#cv2VehiclesList');
        if (!$list.length) { return; }
        $.get($list.data('list-url'), function (html) {
            $list.html(html);
        }).fail(function () {
            $list.html('<div class="text-center cv2-empty" style="padding:24px;">Failed to load.</div>');
        });
    }
    if ($('#cv2VehiclesList').length) { loadVehicles(); }

    $('#cv2VehicleForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Vehicle allocated.' });
                $('#cv2VehicleModal').modal('hide');
                $form[0].reset();
                loadVehicles();
            },
            error: handleAjaxError
        });
    });

    /* ===============================================================
     | DOCUMENTS tab — upload + delete
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
            $.post('/contacts/v2/customers/attachment/delete', { id: id }, function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                setTimeout(function () { window.location.reload(); }, 900);
            }).fail(handleAjaxError);
        });
    });

    /* ===============================================================
     | ACTIVITY tab — add note
     | =============================================================== */
    $('#cv2ActivityForm').on('submit', function (e) {
        e.preventDefault();
        var $form = $(this);
        var $btn  = $form.find('button[type="submit"]').prop('disabled', true);
        clearValidationErrors($form);
        $.ajax({
            url: $form.attr('action'), method: 'POST', data: $form.serialize(),
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message || 'Note saved.' });
                var url = $form.data('list-url');
                setTimeout(function () { if (url) { window.location.href = url; } else { window.location.reload(); } }, 900);
            },
            error: function (xhr) { $btn.prop('disabled', false); handleAjaxError(xhr); }
        });
    });
});
