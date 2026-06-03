/* ============================================================
   Trip Edit Page — edit.js v1.1
   Scope: resources/views/trip/edit.blade.php
   SD-1: All JS in external file — no inline scripts in blade.
   SD-7: Toast.fire() for all success/error notifications.
   NOTE: Form submission not wired — future sprint.
   ============================================================ */

$(document).ready(function () {

    /* ── Toast mixin (SD-7) ─────────────────────────────────────── */
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

    /* ── Trip Date (daterangepicker — single, matches create.js) ── */
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

    /* ── RAG Status selection ───────────────────────────────────── */
    $(document).on('click', '.rag-btn', function () {
        $('.rag-btn').removeClass('rag-selected');
        $(this).addClass('rag-selected');
        $('#ragStatusInput').val($(this).data('value'));
    });

    /* ── Vehicle Type → Vehicle Size (cascade — UI only) ────────── */
    // Full AJAX wiring deferred to the sprint that makes edit functional.
    $('#vehicletype_id').on('change', function () {
        if (!$(this).val()) {
            $('#vehicletypesize_id')
                .html('<option value="">Select vehicle type first</option>')
                .prop('disabled', true);
        }
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

    /* ── Form submit — not functional yet ──────────────────────── */
    $('#editTripForm').on('submit', function (e) {
        e.preventDefault();
        Toast.fire({ icon: 'info', title: 'Edit not yet wired — coming in a future sprint.' });
    });

});
