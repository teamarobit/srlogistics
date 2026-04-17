/**
 * Warehouse Master — Edit Page JS
 * SR Logistics | public/js/Warehouse/edit.js v1.2
 *
 * Blade config via data-* on #whEditForm:
 *   data-cities-url   — URL template with __STATE_ID__ placeholder
 *   data-saved-state  — $wh->state_id
 *   data-saved-city   — $wh->city_name
 *   data-index-url    — route('warehouse.master.index')
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

    var $form      = $('#whEditForm');
    var CITIES_URL = $form.data('cities-url');
    var savedState = $form.data('saved-state');
    var savedCity  = $form.data('saved-city');

    // ── SD-13: intl-tel-input — Contact Number ────────────────
    var itiPhone = null;
    var phoneEl  = document.getElementById('wh_contact_number');
    if (phoneEl && typeof window.intlTelInput === 'function') {
        itiPhone = window.intlTelInput(phoneEl, {
            initialCountry:   'in',            // +91 India default
            separateDialCode: true,
            preferredCountries: ['in'],
            utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js',
        });
        // If saved number is in E.164 (+91…) or plain format, set it
        var savedNumber = phoneEl.value;
        if (savedNumber) {
            itiPhone.setNumber(savedNumber);
        }
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
            if (!$('#wh_city_name option[value="' + preselect + '"]').length) {
                $('#wh_city_name').append(new Option(preselect, preselect, true, true));
            }
            $('#wh_city_name').val(preselect).trigger('change');
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
            $.each(cities, function (i, c) {
                $('#wh_city_name').append(new Option(c.name, c.name, false, false));
            });
            initCitySelect2(preselectCity || null);
        }).fail(function () {
            $('#wh_city_name').prop('disabled', false).empty();
            initCitySelect2(preselectCity || null);
        });
    }

    // ── On page load: load saved state's cities ───────────────
    loadCities(savedState, savedCity);

    // ── State change → reload cities ─────────────────────────
    $('#wh_state_id').on('change', function () {
        if ($('#wh_city_name').hasClass('select2-hidden-accessible')) {
            $('#wh_city_name').select2('destroy');
        }
        $('#wh_city_name').empty().prop('disabled', true);
        loadCities($(this).val(), null);
    });

    // ── Validation helpers (SD-4) ─────────────────────────────
    function showValidationErrors(errors) {
        clearValidationErrors();
        $.each(errors, function (field, messages) {
            var $input = $('[name="' + field + '"]');
            if ($input.length) {
                $('<span class="text-danger small d-block mt-1 field-error">'
                    + messages[0] + '</span>').insertAfter($input);
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

        // SD-13: set full E.164 number (+919876543210) before serialize
        if (itiPhone) {
            $('#wh_contact_number').val(itiPhone.getNumber());
        }

        var $btn = $('#btnSave');
        $('#btnSaveText').text('Updating…');
        $('#btnSaveSpinner').removeClass('d-none');
        $btn.prop('disabled', true);

        // Laravel PUT via POST + _method spoofing (already in form via @method('PUT'))
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
                $('#btnSaveText').text('Update Warehouse');
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
