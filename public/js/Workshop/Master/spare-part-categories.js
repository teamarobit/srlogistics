/* ────────────────────────────────────────────────────────────────────────────
 * Workshop ▸ Master ▸ Spare Part Categories
 * SD-1 (no inline JS), SD-3 (jQuery + $.ajax), SD-4 (red text only, no border),
 * SD-7 (SweetAlert Toast.fire), SD-9 status handling on client side.
 *
 * Edit / Toggle / Remove use delegated handlers that read data-* from the row,
 * matching the Spare Parts Master page. (Replaces the previous inline-onclick
 * approach where @json() emitted literal quotes that broke the onclick attribute.)
 * ──────────────────────────────────────────────────────────────────────────── */
$(function () {
    'use strict';

    /* ── Config ───────────────────────────────────────────────────────────── */
    const CSRF = $('meta[name="csrf-token"]').attr('content') || '';
    const BASE = $('#spcPageRoot').data('base-url') || '';

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });

    /* ── SweetAlert Toast mixin (SD-7) ────────────────────────────────────── */
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

    /* ── Validation helpers (SD-4: red text only, NO red border) ──────────── */
    function clearErrors(prefix) {
        $('[id^="' + prefix + '_"][id$="_error"]').text('');
    }
    function showErrors(prefix, errors) {
        $.each(errors, function (field, msgs) {
            const msg = Array.isArray(msgs) ? msgs[0] : msgs;
            $('#' + prefix + '_' + field + '_error').text(msg);
        });
    }

    /* ── ADD ──────────────────────────────────────────────────────────────── */
    $('#addCategoryForm').on('submit', function (e) {
        e.preventDefault();
        clearErrors('add');
        const $btn = $('#addCategoryBtn');
        const $sp  = $('#addSpinner');
        $btn.prop('disabled', true); $sp.removeClass('d-none');

        $.ajax({
            url:    BASE,
            method: 'POST',
            data:   $(this).serialize(),
            success: function (res) {
                if (res.success) {
                    bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide();
                    $('#addCategoryForm')[0].reset();
                    Toast.fire({ icon: 'success', title: res.message });
                    setTimeout(function () { location.reload(); }, 900);
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'An error occurred.' });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    showErrors('add', xhr.responseJSON.errors);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: (xhr.responseJSON && xhr.responseJSON.message) || 'Server error. Please try again.'
                    });
                }
            },
            complete: function () {
                $btn.prop('disabled', false); $sp.addClass('d-none');
            }
        });
    });

    /* ── Open EDIT modal (delegated — reads data-* from row) ───────────────── */
    $(document).on('click', '.sp-edit', function () {
        clearErrors('edit');
        const $row = $(this).closest('tr');
        $('#edit_id').val($row.data('id'));
        $('#edit_name').val($row.data('name'));
        $('#edit_code').val($row.data('code') || '');
        $('#edit_description').val($row.data('description') || '');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('editCategoryModal')).show();
    });

    /* ── EDIT ─────────────────────────────────────────────────────────────── */
    $('#editCategoryForm').on('submit', function (e) {
        e.preventDefault();
        clearErrors('edit');
        const id   = $('#edit_id').val();
        const $btn = $('#editCategoryBtn');
        const $sp  = $('#editSpinner');
        $btn.prop('disabled', true); $sp.removeClass('d-none');

        $.ajax({
            url:    BASE + '/' + id,
            method: 'POST',
            data:   $(this).serialize(), // includes _method=PUT
            success: function (res) {
                if (res.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editCategoryModal')).hide();
                    Toast.fire({ icon: 'success', title: res.message });
                    setTimeout(function () { location.reload(); }, 900);
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'An error occurred.' });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    showErrors('edit', xhr.responseJSON.errors);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: (xhr.responseJSON && xhr.responseJSON.message) || 'Server error. Please try again.'
                    });
                }
            },
            complete: function () {
                $btn.prop('disabled', false); $sp.addClass('d-none');
            }
        });
    });

    /* ── Toggle status (delegated, SweetAlert confirm) ────────────────────── */
    $(document).on('click', '.sp-toggle', function () {
        const $row = $(this).closest('tr');
        const id            = $row.data('id');
        const currentStatus = $row.data('status');
        const action        = currentStatus === 'Active' ? 'deactivate' : 'activate';

        Swal.fire({
            icon:  'warning',
            title: 'Are you sure?',
            text:  'Do you want to ' + action + ' this category?',
            showCancelButton: true,
            confirmButtonText: 'Yes, ' + action,
            cancelButtonText:  'Cancel',
            confirmButtonColor: '#032671'
        }).then(function (r) {
            if (!r.isConfirmed) return;

            $.ajax({
                url:    BASE + '/' + id + '/status',
                method: 'POST',
                data:   { _method: 'PATCH', _token: CSRF },
                success: function (res) {
                    if (res.success) {
                        Toast.fire({ icon: 'success', title: res.message });
                        setTimeout(function () { location.reload(); }, 700);
                    } else {
                        Toast.fire({ icon: 'error', title: res.message || 'Could not update status.' });
                    }
                },
                error: function (xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: (xhr.responseJSON && xhr.responseJSON.message) || 'Server error.'
                    });
                }
            });
        });
    });

    /* ── Delete (delegated, SweetAlert confirm + server-side blockers guard) ───
     * Mirrors the Warehouse delete UX: if the category has dependent rows
     * the client shows a warning preview, but the controller is the source
     * of truth — a 422 from the server is surfaced as a Swal "blocked" alert.
     * ─────────────────────────────────────────────────────────────────── */
    $(document).on('click', '.sp-remove', function () {
        const $row = $(this).closest('tr');
        const id         = $row.data('id');
        const name       = $row.data('name');
        const partsCount = parseInt($row.data('parts-count'), 10) || 0;

        // ── Client-side preview: if dependent rows exist, refuse up-front ──
        if (partsCount > 0) {
            Swal.fire({
                icon:  'error',
                title: 'Cannot remove "' + name + '"',
                html:  'This category is linked to <strong>' + partsCount +
                       ' spare part' + (partsCount === 1 ? '' : 's') +
                       '</strong>.<br><br>' +
                       'Please reassign or remove those spare parts first.',
                confirmButtonText: 'Got it',
                confirmButtonColor: '#032671'
            });
            return;
        }

        Swal.fire({
            icon:  'question',
            title: 'Remove "' + name + '"?',
            text:  'This can be restored by an administrator.',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove',
            cancelButtonText:  'Cancel',
            confirmButtonColor: '#dc2626'
        }).then(function (r) {
            if (!r.isConfirmed) return;

            $.ajax({
                url:    BASE + '/' + id,
                method: 'POST',
                data:   { _method: 'DELETE', _token: CSRF },
                success: function (res) {
                    if (res.success) {
                        Toast.fire({ icon: 'success', title: res.message });
                        const $r = $('#cat-row-' + id);
                        if ($r.length) {
                            $r.css({ transition: 'opacity .35s', opacity: 0 });
                            setTimeout(function () { $r.remove(); }, 350);
                        }
                    } else {
                        Toast.fire({ icon: 'error', title: res.message || 'Could not delete category.' });
                    }
                },
                error: function (xhr) {
                    // Server-side blockers guard returns 422 — show as a
                    // modal alert (not a transient toast) so the user reads it.
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.message) {
                        Swal.fire({
                            icon:  'error',
                            title: 'Cannot remove "' + name + '"',
                            text:  xhr.responseJSON.message,
                            confirmButtonText: 'Got it',
                            confirmButtonColor: '#032671'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: (xhr.responseJSON && xhr.responseJSON.message) || 'Server error.'
                        });
                    }
                }
            });
        });
    });

    /* ── Filter form: Enter on search + strip empty params on submit ──────── */
    $('input[name="search"]').on('keypress', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); $('#spFilterForm').trigger('submit'); }
    });

    $('#spFilterForm').on('submit', function () {
        // Remove name= attribute from any field whose value is empty so it
        // doesn't serialize into the URL (e.g. ?search=QAT&status= → ?search=QAT)
        $(this).find('input, select').each(function () {
            const $el = $(this);
            if ($el.val() === '' || $el.val() === null) {
                $el.removeAttr('name');
            }
        });
    });
});
