/**
 * Tyre Details — Schedule Maintenance Modal JS
 * File: public/js/tyre/maintenance.js  v1.0
 *
 * SD-1: All maintenance modal logic lives here — no inline <script> in the blade.
 * SD-7: Toast.fire() for all success/error notifications.
 */
(function () {
    'use strict';

    // ── Toast mixin (SD-7) ──────────────────────────────────────────────────
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

    // ── Config (from data-* / <meta>) ───────────────────────────────────────
    const $cfg       = $('#tyreShowConfig');
    const STORE_URL  = $cfg.data('maint-store-url');
    const SERIAL     = $cfg.data('tyre-serial') || '';
    const CSRF       = $('meta[name="csrf-token"]').attr('content') || '';

    const $modal     = $('#add05_maintenance');
    const $form      = $('#maintForm');
    const $saveBtn   = $('#maintSaveBtn');
    const $saveTxt   = $('#maintSaveBtnText');
    const $saveSpn   = $('#maintSaveBtnSpinner');

    // ── Badge helper ────────────────────────────────────────────────────────
    function badgeClass(status) {
        const map = { Scheduled: 'badge-primary', Pending: 'badge-warning', Done: 'badge-success', Overdue: 'badge-danger' };
        return map[status] || 'badge-secondary';
    }

    // ── Reset form to "Add" mode ────────────────────────────────────────────
    function resetModal() {
        $form[0].reset();
        $('#maint_schedule_id').val('');
        $('#maint_method_override').val('store');
        $form.attr('action', STORE_URL);
        $saveTxt.text('Save Schedule');
        $('#maintModalLabel').html('<i class="uil uil-wrench me-2"></i>Schedule Maintenance &mdash; <span class="text-muted fw-normal fs-6">' + SERIAL + '</span>');
        clearErrors();
    }

    function clearErrors() {
        $('#maint_item_err').addClass('d-none').text('');
    }

    // ── Loading state ───────────────────────────────────────────────────────
    function setBusy(busy) {
        $saveBtn.prop('disabled', busy);
        $saveSpn.toggleClass('d-none', !busy);
    }

    // ── Reset on open (only when NOT triggered by edit btn) ─────────────────
    $modal.on('show.bs.modal', function (e) {
        if (!$(e.relatedTarget).hasClass('maint-edit-btn')) {
            resetModal();
        }
    });

    // ── Edit button click: pre-fill form ───────────────────────────────────
    $(document).on('click', '.maint-edit-btn', function () {
        const d = $(this).data();
        resetModal();

        $('#maint_schedule_id').val(d.id);
        $('#maint_method_override').val('update');
        $form.attr('action', d.updateUrl);

        $('#maint_item').val(d.item);
        $('#maint_last_done').val(d.last);
        $('#maint_next_due').val(d.next);
        $('#maint_odometer').val(d.odometer);
        $('#maint_status').val(d.status);
        $('#maint_notes').val(d.notes);

        $saveTxt.text('Update Schedule');
        $('#maintModalLabel').html('<i class="uil uil-pen me-2"></i>Edit Maintenance &mdash; <span class="text-muted fw-normal fs-6">' + SERIAL + '</span>');

        $modal.modal('show');
    });

    // ── Save / Update ───────────────────────────────────────────────────────
    $saveBtn.on('click', function () {
        clearErrors();

        const item = $('#maint_item').val().trim();
        if (!item) {
            $('#maint_item_err').removeClass('d-none').text('Maintenance item is required.');
            return;
        }

        const isUpdate   = $('#maint_method_override').val() === 'update';
        const actionUrl  = $form.attr('action');
        const scheduleId = $('#maint_schedule_id').val();

        const payload = {
            _token:           CSRF,
            maintenance_item: item,
            last_done_date:   $('#maint_last_done').val(),
            next_due_date:    $('#maint_next_due').val(),
            odometer_km:      $('#maint_odometer').val(),
            status:           $('#maint_status').val(),
            notes:            $('#maint_notes').val(),
        };

        setBusy(true);

        $.ajax({
            url:    actionUrl,
            method: 'POST',
            data:   payload,
            success: function (res) {
                setBusy(false);
                $modal.modal('hide');
                Toast.fire({ icon: 'success', title: res.message || 'Saved successfully.' });

                if (isUpdate) {
                    // Update the existing row in place
                    const $row = $('#maint-row-' + scheduleId);
                    $row.find('td:eq(0)').text(payload.maintenance_item);
                    $row.find('td:eq(1)').text(payload.last_done_date ? formatDateDMY(payload.last_done_date) : '—');
                    $row.find('td:eq(2)').text(payload.next_due_date  ? formatDateDMY(payload.next_due_date)  : '—');
                    $row.find('td:eq(3)').text(payload.odometer_km    ? Number(payload.odometer_km).toLocaleString() : '—');
                    $row.find('td:eq(4)').html('<span class="badge ' + badgeClass(payload.status) + '">' + payload.status + '</span>');
                    // Refresh data-* attrs on edit btn
                    $row.find('.maint-edit-btn')
                        .data('item',     payload.maintenance_item)
                        .data('last',     payload.last_done_date)
                        .data('next',     payload.next_due_date)
                        .data('odometer', payload.odometer_km)
                        .data('status',   payload.status)
                        .data('notes',    payload.notes)
                        .attr('data-item',     payload.maintenance_item)
                        .attr('data-last',     payload.last_done_date)
                        .attr('data-next',     payload.next_due_date)
                        .attr('data-odometer', payload.odometer_km)
                        .attr('data-status',   payload.status)
                        .attr('data-notes',    payload.notes);
                } else {
                    // Reload to get the new row with correct id
                    setTimeout(function () { location.reload(); }, 600);
                }
            },
            error: function (xhr) {
                setBusy(false);
                Toast.fire({ icon: 'error', title: xhr.responseJSON?.message || 'Something went wrong.' });
            }
        });
    });

    // ── Delete ──────────────────────────────────────────────────────────────
    $(document).on('click', '.maint-delete-btn', function () {
        const scheduleId  = $(this).data('id');
        const deleteUrl   = $(this).data('deleteUrl');

        Swal.fire({
            title: 'Delete this maintenance schedule?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url:    deleteUrl,
                method: 'POST',
                data:   { _token: CSRF },
                success: function (res) {
                    Toast.fire({ icon: 'success', title: res.message || 'Deleted.' });
                    $('#maint-row-' + scheduleId).fadeOut(300, function () {
                        $(this).remove();
                        // Show empty row if tbody is now empty
                        if ($('tbody .maint-edit-btn').length === 0) {
                            $('tbody').append(
                                '<tr id="maint-empty-row"><td colspan="6" class="text-center text-muted py-4">' +
                                '<i class="uil uil-calendar-slash fs-4 d-block mb-1"></i>' +
                                'No maintenance schedules yet. Click <strong>Schedule Maintenance</strong> to add one.</td></tr>'
                            );
                        }
                    });
                },
                error: function (xhr) {
                    Toast.fire({ icon: 'error', title: xhr.responseJSON?.message || 'Could not delete.' });
                }
            });
        });
    });

    // ── Date format helper (YYYY-MM-DD → DD-MM-YYYY) ────────────────────────
    function formatDateDMY(ymd) {
        if (!ymd) return '—';
        const parts = ymd.split('-');
        return parts.length === 3 ? parts[2] + '-' + parts[1] + '-' + parts[0] : ymd;
    }

})();
