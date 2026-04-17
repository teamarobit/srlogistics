/**
 * Warehouse Master — Create Page JS
 * SR Logistics | public/js/Warehouse/create.js v1.1
 *
 * Blade config via data-* on #whCreateForm:
 *   data-cities-url  — URL template with __STATE_ID__ placeholder
 *   data-old-state   — old('state_id') value
 *   data-old-city    — old('city_name') value
 *   data-index-url   — route('warehouse.master.index')
 *
 * SD-1: No inline JS in blade.
 * SD-3: Form submit via $.ajax(). No plain POST.
 * SD-4: Validation errors as red text below field — no red border.
 * SD-7: Toast.fire() for all notifications.
 */

// SD-7: Define Toast mixin once at top of file
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
