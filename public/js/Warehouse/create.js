/**
 * Warehouse Master — Create Page JS
 * SR Logistics | public/js/Warehouse/create.js v1.7
 *
 * v1.7 (2026-06-26): Phone flag dropped down when a validation error showed.
 *                    showValidationErrors() inserted the error span after the
 *                    input, which iti has moved INSIDE the .iti wrapper — the
 *                    wrapper grew and the v25 .iti__country-container recentred
 *                    the flag. Now insert after the .iti wrapper instead.
 * v1.3 (2026-05-25): BUG-004 — layout already loads intl-tel-input v17.0.3
 *                    (js + utils). Removed utilsScript to avoid third version.
 *
 * Blade config via data-* on #whCreateForm:
 *   data-cities-url  — URL template with __STATE_ID__ placeholder
 *   data-old-state   — old('state_id') value
 *   data-old-city    — old('city_name') value
 *   data-index-url   — route('warehouse.master.index')
 *
 * SD-1:  No inline JS in blade.
 * SD-3:  Form submit via $.ajax(). No plain POST.
 * SD-4:  Validation errors as red text below field — no red border.
 * SD-7:  Toast.fire() for all notifications.
 * SD-13: intl-tel-input on #wh_contact_number, default country IN (+91).
 */

/* ── SD-7: Toast mixin ───────────────────────────────── */
const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

$(function () {

    var $form      = $('#whCreateForm');
    var CITIES_URL = $form.data('cities-url');
    var oldStateId = $form.data('old-state');
    var oldCity    = $form.data('old-city');

    // ── SD-13: intl-tel-input — Contact Number ────────────────
    var itiPhone = null;
    var phoneEl  = document.getElementById('wh_contact_number');
    if (phoneEl && typeof window.intlTelInput === 'function') {
        // BUG-004 fix: layout loads two iti versions and v25.15.0 is the one
        // that ends up as window.intlTelInput. Point utilsScript at v25's utils
        // so getNumber() returns the full E.164 string (otherwise it returns "").
        itiPhone = window.intlTelInput(phoneEl, {
            initialCountry:   'in',            // +91 India default
            separateDialCode: true,
            preferredCountries: ['in'],
            utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@25.15.0/build/js/utils.js',
        });
    }

    // ── Select2: State ────────────────────────────────────────
    $('#wh_state_id').select2({ placeholder: 'Select State', width: '100%' });

    // ── Select2: Manager ──────────────────────────────────────
    $('#wh_manager_contact_id').select2({
        placeholder: 'Select Manager (Employee)',
        allowClear: true,
        width: '100%',
    });

    // ── City Select2 (tags mode) ──────────────────────────────
    function initCitySelect2(preselect) {
        if ($('#wh_city_name').hasClass('select2-hidden-accessible')) {
            $('#wh_city_name').select2('destroy');
        }
        $('#wh_city_name').select2({
            placeholder: 'Type or select city',
            tags: true,
            width: '100%',
            createTag: function (params) {
                var term = $.trim(params.term);
                if (!term) return null;
                return { id: term, text: term, newTag: true };
            },
            insertTag: function (data, tag) { data.unshift(tag); },
        });
        if (preselect) {
            $('#wh_city_name').append(new Option(preselect, preselect, true, true)).trigger('change');
        }
    }

    // ── Load cities for a state ───────────────────────────────
    function loadCities(stateId, preselectCity) {
        if (!stateId) {
            $('#wh_city_name').prop('disabled', true).empty();
            initCitySelect2(null);
            return;
        }
        var url = CITIES_URL.replace('__STATE_ID__', stateId);
        $.getJSON(url, function (cities) {
            $('#wh_city_name').prop('disabled', false).empty();
            // Issue 3: blank placeholder option first so Select2 auto-selects nothing
            $('#wh_city_name').append(new Option('', '', false, false));
            $.each(cities, function (i, c) {
                $('#wh_city_name').append(new Option(c.name, c.name, false, false));
            });
            initCitySelect2(preselectCity || null);
        }).fail(function () {
            $('#wh_city_name').prop('disabled', false).empty();
            initCitySelect2(preselectCity || null);
        });
    }

    // ── State change → reload cities ─────────────────────────
    $('#wh_state_id').on('change', function () {
        if ($('#wh_city_name').hasClass('select2-hidden-accessible')) {
            $('#wh_city_name').select2('destroy');
        }
        $('#wh_city_name').empty().prop('disabled', true);
        loadCities($(this).val(), null);
    });

    // ── On page load: restore old state/city if validation fail
    if (oldStateId) {
        loadCities(oldStateId, oldCity || null);
    } else {
        initCitySelect2(null);
    }

    // ── Validation helpers (SD-4) ─────────────────────────────
    function showValidationErrors(errors) {
        clearValidationErrors();
        $.each(errors, function (field, messages) {
            var $input = $('[name="' + field + '"]');
            if ($input.length) {
                // intl-tel-input wraps #wh_contact_number inside a .iti div.
                // Insert the error after the .iti wrapper (not the input), so the
                // wrapper height stays = input height and the flag does not drop down.
                var $iti = $input.closest('.iti');
                var $target = $iti.length ? $iti : $input;
                $('<span class="text-danger small d-block mt-1 field-error">'
                    + messages[0] + '</span>').insertAfter($target);
            }
        });
        var $first = $('.field-error').first();
        if ($first.length) {
            $('html, body').animate({ scrollTop: $first.offset().top - 100 }, 300);
        }
    }

    function clearValidationErrors() {
        $('.field-error').remove();
    }

    // ── Form submit via $.ajax() (SD-3) ──────────────────────
    $form.on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        // Issue 5: separateDialCode → input holds national digits only.
        // When a number is entered it must be exactly 10 digits.
        var contactDigits = ($('#wh_contact_number').val() || '').replace(/\D/g, '');
        if (contactDigits.length > 0 && contactDigits.length !== 10) {
            showValidationErrors({ contact_number: ['Enter a valid 10-digit phone number.'] });
            return;
        }

        // SD-13: set full E.164 number (+919876543210) before serialize.
        // BUG-004 followup: global layout loads two iti versions; getNumber()
        // can return empty when utils version mismatches. Fall back to manual
        // build from dialCode + cleaned digits.
        if (itiPhone) {
            var e164 = '';
            try { e164 = itiPhone.getNumber() || ''; } catch (err) { e164 = ''; }
            var rawDigits = ($('#wh_contact_number').val() || '').replace(/\D/g, '');
            if (!e164 && rawDigits && typeof itiPhone.getSelectedCountryData === 'function') {
                var cd = itiPhone.getSelectedCountryData() || {};
                if (cd.dialCode) e164 = '+' + cd.dialCode + rawDigits;
            }
            if (e164) $('#wh_contact_number').val(e164);
        }

        var $btn = $('#btnSave');
        $('#btnSaveText').text('Saving…');
        $('#btnSaveSpinner').removeClass('d-none');
        $btn.prop('disabled', true);

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            },
            success: function (res) {
                Toast.fire({ icon: 'success', title: res.message });
                setTimeout(function () {
                    window.location.href = res.redirect || $form.data('index-url');
                }, 1200);
            },
            error: function (xhr) {
                $btn.prop('disabled', false);
                $('#btnSaveText').text('Save Warehouse');
                $('#btnSaveSpinner').addClass('d-none');

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    showValidationErrors(xhr.responseJSON.errors);
                } else {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message : 'Something went wrong. Please try again.';
                    Toast.fire({ icon: 'error', title: msg });
                }
            }
        });
    });

});
