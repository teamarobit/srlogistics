/* ============================================================
   Trip Module — create.js v1.0
   Scope: resources/views/trip/create.blade.php
   SD-1: All JS in external file — no inline scripts in blade.
   SD-7: Toast.fire() for all success/error notifications.
   SD-3: $.ajax() for all form submissions.
   ============================================================ */

$(document).ready(function () {

    /* ── Toast mixin (SD-7) ────────────────────────────────────── */
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: function (toast) {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    var $form     = $('#createTripForm');
    var INDEX_URL = $form.data('index-url');
    var SIZES_URL = $form.data('sizes-url');

    /* ── Trip Date (daterangepicker — single) ───────────────────── */
    $('#trip_date').daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false,
        locale: { format: 'DD/MM/YYYY', cancelLabel: 'Clear' }
    });
    $('#trip_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#trip_date').on('cancel.daterangepicker', function () {
        $(this).val('');
    });

    /* ── Select2 — all static dropdowns ────────────────────────── */
    ['#trip_type', '#load_vendor_id', '#customer_id',
     '#vehicletype_id', '#vehicletypesize_id', '#route_id'
    ].forEach(function (sel) {
        $(sel).select2({ width: '100%' });
    });

    /* ── RAG Status selection ────────────────────────────────────── */
    $(document).on('click', '.rag-btn', function () {
        $('.rag-btn').removeClass('rag-selected');
        $(this).addClass('rag-selected');
        $('#ragStatusInput').val($(this).data('value'));
    });

    /* ── Vehicle Type → Vehicle Size (cascading AJAX) ───────────── */
    $('#vehicletype_id').on('change', function () {
        var typeId  = $(this).val();
        var $sizeEl = $('#vehicletypesize_id');

        $sizeEl.html('<option value="">Loading...</option>').prop('disabled', true);

        if (!typeId) {
            $sizeEl.html('<option value="">Select vehicle type first</option>').prop('disabled', true);
            return;
        }

        var url = SIZES_URL.replace('__ID__', typeId);

        $.ajax({
            url: url,
            method: 'GET',
            success: function (res) {
                if (res.success && res.sizes.length) {
                    var opts = '<option value="">Choose..</option>';
                    $.each(res.sizes, function (i, s) {
                        var dims = (s.length && s.height && s.width)
                            ? ' (' + s.length + ' × ' + s.height + ' × ' + s.width + ')'
                            : '';
                        opts += '<option value="' + s.id + '">' + s.name + dims + '</option>';
                    });
                    if ($sizeEl.hasClass('select2-hidden-accessible')) { $sizeEl.select2('destroy'); }
                    $sizeEl.html(opts).prop('disabled', false);
                    $sizeEl.select2({ width: '100%' });
                } else {
                    if ($sizeEl.hasClass('select2-hidden-accessible')) { $sizeEl.select2('destroy'); }
                    $sizeEl.html('<option value="">No sizes available</option>').prop('disabled', true);
                }
            },
            error: function () {
                $sizeEl.html('<option value="">Failed to load sizes</option>').prop('disabled', true);
                Toast.fire({ icon: 'error', title: 'Could not load vehicle sizes.' });
            }
        });
    });

    /* ── Midpoint — dynamic add/remove rows ─────────────────────── */
    var _mpIdx = 0;

    $('#btnAddMidpoint, #linkAddMidpoint').on('click', function (e) {
        e.preventDefault();
        _mpIdx++;
        var idx = _mpIdx;
        var row =
            '<div class="row mb-2 midpoint-entry" id="mpEntry_' + idx + '">' +
                '<div class="col-md-6 form-group">' +
                    '<label class="form-label">Mid Point</label>' +
                    '<select class="form-select mp-select" id="mp_loc_' + idx + '" name="midpoints[' + idx + '][location]" style="width:100%;"></select>' +
                '</div>' +
                '<div class="col-md-6 form-group">' +
                    '<div class="d-flex align-items-end" style="gap:10px;">' +
                        '<div class="flex-grow-1">' +
                            '<label class="form-label">Midpoint Type</label>' +
                            '<div class="d-flex align-items-center" style="min-height:38px; gap:8px;">' +
                                '<div class="form-check form-check-inline radio-chip me-2">' +
                                    '<input class="form-check-input" type="radio" name="midpoints[' + idx + '][type]" id="mp_l_' + idx + '" value="Loading">' +
                                    '<label class="form-check-label" for="mp_l_' + idx + '"><i class="uil uil-check-circle me-1"></i>Loading</label>' +
                                '</div>' +
                                '<div class="form-check form-check-inline radio-chip">' +
                                    '<input class="form-check-input" type="radio" name="midpoints[' + idx + '][type]" id="mp_u_' + idx + '" value="Unloading">' +
                                    '<label class="form-check-label" for="mp_u_' + idx + '"><i class="uil uil-check-circle me-1"></i>Unloading</label>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div style="padding-bottom:6px;">' +
                            '<i class="uil uil-trash-alt text-danger remove-midpoint" style="cursor:pointer; font-size:18px;" data-idx="' + idx + '"></i>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        $('#midpointContainer').append(row);

        /* Init Select2 on the newly added midpoint select */
        $('#mp_loc_' + idx).select2({ width: '100%', placeholder: 'Select midpoint' });
    });

    $(document).on('click', '.remove-midpoint', function () {
        $('#mpEntry_' + $(this).data('idx')).remove();
    });

    /* ── Validation helpers (SD-4) ──────────────────────────────── */
    function showValidationErrors(errors) {
        clearValidationErrors();
        $.each(errors, function (field, messages) {
            var $input = $('[name="' + field + '"]');
            if ($input.length) {
                $('<span class="text-danger small d-block mt-1 field-error">' + messages[0] + '</span>').insertAfter($input);
            }
        });
        var $first = $('.field-error').first();
        if ($first.length) {
            $('html, body').animate({ scrollTop: $first.offset().top - 100 }, 300);
        }
    }
    function clearValidationErrors() { $('.field-error').remove(); }

    /* ── Create Trip Form Submit (SD-3: $.ajax) ──────────────────── */
    $form.on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        var $btn = $('#btnSaveTrip');
        $('#btnSaveTripText').text('Saving…');
        $('#btnSaveTripSpinner').removeClass('d-none');
        $btn.prop('disabled', true);

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (res) {
                if (res.success) {
                    Toast.fire({ icon: 'success', title: res.message || 'Trip created!' });
                    setTimeout(function () { window.location.href = INDEX_URL; }, 1200);
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Failed to save trip.' });
                    $btn.prop('disabled', false);
                    $('#btnSaveTripText').text('Save Trip');
                    $('#btnSaveTripSpinner').addClass('d-none');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    showValidationErrors(xhr.responseJSON.errors);
                    Toast.fire({ icon: 'error', title: 'Please fix the errors below.' });
                } else {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message
                        : 'An error occurred.';
                    Toast.fire({ icon: 'error', title: msg });
                }
                $btn.prop('disabled', false);
                $('#btnSaveTripText').text('Save Trip');
                $('#btnSaveTripSpinner').addClass('d-none');
            }
        });
    });

});
