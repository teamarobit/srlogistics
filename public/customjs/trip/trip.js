/* ============================================================
   Trip Module — trip.js v1.5
   Scope: resources/views/trip/index.blade.php
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

    /* ── Filter collapse toggle ─────────────────────────────────── */
    $('#filterToggle').on('click', function () {
        $('#filterBody').slideToggle(200);
        $(this).find('.bi').toggleClass('bi-chevron-up bi-chevron-down');
    });

    /* ── RAG Status selection ────────────────────────────────────── */
    $(document).on('click', '.rag-btn', function () {
        $('.rag-btn').removeClass('rag-selected');
        $(this).addClass('rag-selected');
        $('#ragStatusInput').val($(this).data('value'));
    });

    /* ── Trip Date — singleDatePicker (init once on modal shown) ───── */
    $('#createTripModal').on('shown.bs.modal', function () {
        if (!$('#trip_date').data('daterangepicker')) {
            $('#trip_date').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Clear'
                }
            });
            $('#trip_date').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'));
            });
            $('#trip_date').on('cancel.daterangepicker', function () {
                $(this).val('');
            });
        }
    });

    /* ── Open Create Trip Modal ──────────────────────────────────── */
    $('#btnAddTrip').on('click', function () {
        $('#createTripForm')[0].reset();
        $('.rag-btn').removeClass('rag-selected');
        $('#ragStatusInput').val('');
        $('#midpointContainer').empty();
        $('#tripModal_id').val('Auto Generated');
        $('#vehicletypesize_id').html('<option value="">Select vehicle type first</option>').prop('disabled', true);
        $('#createTripModal').modal('show');
    });

    /* ── Vehicle Type → Vehicle Size (cascading AJAX) ───────────── */
    $('#vehicletype_id').on('change', function () {
        var typeId   = $(this).val();
        var $sizeEl  = $('#vehicletypesize_id');

        $sizeEl.html('<option value="">Loading...</option>').prop('disabled', true);

        if (!typeId) {
            $sizeEl.html('<option value="">Select vehicle type first</option>').prop('disabled', true);
            return;
        }

        var url = $('#vehicletype_id').data('sizes-url').replace('__ID__', typeId);

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
                    $sizeEl.html(opts).prop('disabled', false);
                } else {
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

    $('#btnAddMidpoint').on('click', function () {
        _mpIdx++;
        var idx = _mpIdx;
        var row =
            '<div class="row mb-2 midpoint-entry" id="mpEntry_' + idx + '">' +
                '<div class="col-md-6 form-group">' +
                    '<label class="form-label">Mid Point</label>' +
                    '<input type="text" class="form-control" name="midpoints[' + idx + '][location]" placeholder="Midpoint location" />' +
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
    });

    $(document).on('click', '.remove-midpoint', function () {
        $('#mpEntry_' + $(this).data('idx')).remove();
    });

    /* ── Create Trip Form Submit (SD-3: $.ajax) ──────────────────── */
    $('#createTripForm').on('submit', function (e) {
        e.preventDefault();

        var $btn = $('#btnSaveTrip');
        $btn.prop('disabled', true).text('Saving…');

        $.ajax({
            url: $('#createTripForm').attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                if (res.success) {
                    $('#createTripModal').modal('hide');
                    Toast.fire({ icon: 'success', title: res.message || 'Trip created!' });
                    // Reload the page to show the new trip in the list
                    setTimeout(function () { location.reload(); }, 1200);
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Failed to save trip.' });
                }
            },
            error: function (xhr) {
                var msg = 'An error occurred.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errs = xhr.responseJSON.errors;
                    msg = Object.values(errs).flat().join(' ');
                }
                Toast.fire({ icon: 'error', title: msg });
            },
            complete: function () {
                $btn.prop('disabled', false).text('Save');
            }
        });
    });

    /* ── Delete Trip ─────────────────────────────────────────────── */
    $(document).on('click', '.btn-trip-delete', function () {
        var tripId  = $(this).data('id');
        var tripRef = $(this).data('ref');

        Swal.fire({
            title: 'Delete Trip?',
            text: 'Are you sure you want to delete ' + tripRef + '? This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/trips/' + tripId,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.success) {
                            Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                            setTimeout(function () { location.reload(); }, 1000);
                        } else {
                            Toast.fire({ icon: 'error', title: res.message || 'Could not delete.' });
                        }
                    },
                    error: function () {
                        Toast.fire({ icon: 'error', title: 'Server error. Please try again.' });
                    }
                });
            }
        });
    });

    /* ── Filter Reset ────────────────────────────────────────────── */
    $('#btnReset').on('click', function () {
        $('#filterForm')[0].reset();
    });

    /* ── Own / External Vehicle Tabs ─────────────────────────────── */
    $('.trip-type-tab').on('click', function () {
        $('.trip-type-tab').removeClass('active');
        $(this).addClass('active');
        var type = $(this).data('type');
        $('#tripTypeInput').val(type);
    });

    /* ── Flash message on page load (session flash) ──────────────── */
    var flashMsg = $('#flashSuccess').text().trim();
    if (flashMsg) {
        Toast.fire({ icon: 'success', title: flashMsg });
    }

    /* ── Auto-open Create Trip modal if ?open=create in URL ──────── */
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('open') === 'create') {
        $('#createTripForm')[0].reset();
        $('.rag-btn').removeClass('rag-selected');
        $('#ragStatusInput').val('');
        $('#midpointContainer').empty();
        $('#tripModal_id').val('Auto Generated');
        $('#createTripModal').modal('show');
    }

});
