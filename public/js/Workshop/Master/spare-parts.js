/* ──────────────────────────────────────────────────────────────────────
 *  Workshop → Master → Spare Parts
 *  Page-level JS (RULE 1 / SD-1 — no inline JS in Blade)
 *  Uses jQuery $.ajax (RULE 3) and SweetAlert2 Toast.fire (RULE 7)
 * ─────────────────────────────────────────────────────────────────── */
(function () {
    'use strict';

    /* ── CSRF + Base URL (data-* on body or meta) ── */
    var CSRF = $('meta[name="csrf-token"]').attr('content') || '';
    var BASE = $('meta[name="sp-base-url"]').attr('content') || '/workshop/master/spare-parts';

    /* ── Global ajax setup: always send X-CSRF-TOKEN header (B-19 hardening) ── */
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
    });

    /* ── Toast mixin (RULE 7) ── */
    var Toast = Swal.mixin({
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

    /* ── Error helpers (RULE 4 — red text below field, never red border) ── */
    function clearErrors(prefix) {
        $('[id^="' + prefix + '_"][id$="_error"]').text('');
    }

    function clearFieldError(prefix, field) {
        $('#' + prefix + '_' + field + '_error').text('');
    }

    function showErrors(prefix, errors) {
        $.each(errors, function (field, msgs) {
            var errId = '#' + prefix + '_' + field + '_error';
            var $err = $(errId);
            if ($err.length) {
                $err.text(msgs[0]);
            }
        });
    }

    /* ── Client-side guards: numeric min=0 (B-05, B-07) + category required (B-08) ── */
    function validateClientSide(prefix) {
        var ok = true;

        var $cost = $('#' + prefix + 'PartForm [name="standard_cost"]');
        if ($cost.length) {
            var cost = parseFloat($cost.val());
            if (isNaN(cost) || cost < 0) {
                $('#' + prefix + '_standard_cost_error').text('Standard cost must be 0 or greater.');
                ok = false;
            } else {
                $('#' + prefix + '_standard_cost_error').text('');
            }
        }

        var $reorder = $('#' + prefix + 'PartForm [name="reorder_level"]');
        if ($reorder.length) {
            var lvl = parseInt($reorder.val(), 10);
            if (isNaN(lvl) || lvl < 0) {
                $('#' + prefix + '_reorder_level_error').text('Reorder level must be 0 or greater.');
                ok = false;
            } else {
                $('#' + prefix + '_reorder_level_error').text('');
            }
        }

        var $cat = $('#' + prefix + '_category_id');
        if ($cat.length) {
            if (!$cat.val()) {
                $('#' + prefix + '_wssparepartscategory_id_error').text('Please select a category.');
                ok = false;
            } else {
                $('#' + prefix + '_wssparepartscategory_id_error').text('');
            }
        }

        return ok;
    }

    /* ── Auto-generate Part No. ── */
    $(document).on('click', '#autoFillPartNoBtn', function () {
        $.ajax({
            url: BASE + '?_auto_no=1',
            method: 'GET',
            dataType: 'json',
            success: function (d) {
                if (d && d.part_no) {
                    $('#add_part_no').val(d.part_no);
                    /* B-06 / B-11 — clear stale error on the field */
                    clearFieldError('add', 'part_no');
                }
            },
            error: function () {
                Toast.fire({ icon: 'error', title: 'Could not auto-generate Part No.' });
            }
        });
    });

    /* ── Add Spare Part (RULE 3 — $.ajax) ── */
    $(document).on('submit', '#addPartForm', function (e) {
        e.preventDefault();
        clearErrors('add');

        if (!validateClientSide('add')) {
            return;
        }

        var $form = $(this);
        var $btn = $('#addPartBtn');
        var $sp = $('#addSpinner');
        $btn.prop('disabled', true);
        $sp.removeClass('d-none');

        $.ajax({
            url: BASE,
            method: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function (d) {
                if (d && d.success) {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('addPartModal'));
                    if (modal) modal.hide();
                    $form[0].reset();
                    Toast.fire({ icon: 'success', title: d.message || 'Spare part added.' });
                    setTimeout(function () { location.reload(); }, 900);
                } else if (d && d.errors) {
                    showErrors('add', d.errors);
                } else {
                    Toast.fire({ icon: 'error', title: (d && d.message) || 'An error occurred.' });
                }
            },
            error: function (xhr) {
                if (xhr && xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    showErrors('add', xhr.responseJSON.errors);
                } else {
                    Toast.fire({ icon: 'error', title: 'Server error. Please try again.' });
                }
            },
            complete: function () {
                $btn.prop('disabled', false);
                $sp.addClass('d-none');
            }
        });
    });

    /* ── B-06 / B-11 — Clear field error on user input ── */
    $(document).on('input change', '#addPartForm input, #addPartForm select, #addPartForm textarea', function () {
        var name = $(this).attr('name');
        if (!name) return;
        clearFieldError('add', name);
    });
    $(document).on('input change', '#editPartForm input, #editPartForm select, #editPartForm textarea', function () {
        var name = $(this).attr('name');
        if (!name) return;
        clearFieldError('edit', name);
    });

    /* ── Open Edit Modal (reads data-* from row) ── */
    $(document).on('click', '.sp-edit', function () {
        clearErrors('edit');
        var $row = $(this).closest('tr');

        $('#edit_id').val($row.data('id'));
        $('#edit_part_no').val($row.data('part-no'));
        $('#edit_name').val($row.data('name'));

        var catId = $row.data('category-id');
        $('#edit_category_id').val(catId ? String(catId) : '').trigger('change');

        $('#edit_compatible_makes').val($row.data('compatible-makes') || '');
        $('#edit_unit').val($row.data('unit'));
        $('#edit_standard_cost').val($row.data('standard-cost'));
        $('#edit_reorder_level').val($row.data('reorder-level'));
        $('#edit_notes').val($row.data('notes') || '');

        bootstrap.Modal.getOrCreateInstance(document.getElementById('editPartModal')).show();
    });

    /* ── Update Spare Part (RULE 3 — $.ajax + spoofed PUT) ── */
    $(document).on('submit', '#editPartForm', function (e) {
        e.preventDefault();
        clearErrors('edit');

        if (!validateClientSide('edit')) {
            return;
        }

        var $form = $(this);
        var id = $('#edit_id').val();
        var $btn = $('#editPartBtn');
        var $sp = $('#editSpinner');
        $btn.prop('disabled', true);
        $sp.removeClass('d-none');

        $.ajax({
            url: BASE + '/' + id,
            method: 'POST',
            data: $form.serialize() + '&_method=PUT',
            dataType: 'json',
            success: function (d) {
                if (d && d.success) {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('editPartModal'));
                    if (modal) modal.hide();
                    Toast.fire({ icon: 'success', title: d.message || 'Spare part updated.' });
                    setTimeout(function () { location.reload(); }, 900);
                } else if (d && d.errors) {
                    showErrors('edit', d.errors);
                } else {
                    Toast.fire({ icon: 'error', title: (d && d.message) || 'An error occurred.' });
                }
            },
            error: function (xhr) {
                if (xhr && xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    showErrors('edit', xhr.responseJSON.errors);
                } else {
                    Toast.fire({ icon: 'error', title: 'Server error. Please try again.' });
                }
            },
            complete: function () {
                $btn.prop('disabled', false);
                $sp.addClass('d-none');
            }
        });
    });

    /* ── Toggle Status (SweetAlert2 confirm — fixes B-13) ── */
    $(document).on('click', '.sp-toggle', function () {
        var $row = $(this).closest('tr');
        var id = $row.data('id');
        var status = $row.data('status');
        var actionLabel = (status === 'Active') ? 'deactivate' : 'activate';

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to ' + actionLabel + ' this spare part?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, ' + actionLabel,
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: BASE + '/' + id + '/status',
                method: 'POST',
                data: { _method: 'PATCH', _token: CSRF },
                dataType: 'json',
                success: function (d) {
                    if (d && d.success) {
                        Toast.fire({ icon: 'success', title: d.message || 'Status updated.' });
                        setTimeout(function () { location.reload(); }, 700);
                    } else {
                        Toast.fire({ icon: 'error', title: (d && d.message) || 'Could not update status.' });
                    }
                },
                error: function () {
                    Toast.fire({ icon: 'error', title: 'Server error.' });
                }
            });
        });
    });

    /* ── Remove Spare Part (SweetAlert2 confirm — fixes B-13) ── */
    $(document).on('click', '.sp-remove', function () {
        var $row = $(this).closest('tr');
        var id = $row.data('id');
        var name = $row.data('name');

        Swal.fire({
            title: 'Remove spare part?',
            html: 'Remove <strong>' + $('<div>').text(name).html() + '</strong> from the spare parts master?<br><span style="font-size:12px;color:#64748b;">This can be restored by an administrator.</span>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc2626'
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: BASE + '/' + id,
                method: 'POST',
                data: { _method: 'DELETE', _token: CSRF },
                dataType: 'json',
                success: function (d) {
                    if (d && d.success) {
                        Toast.fire({ icon: 'success', title: d.message || 'Removed.' });
                        var $r = $('#part-row-' + id);
                        $r.css('transition', 'opacity .35s').css('opacity', 0);
                        setTimeout(function () { $r.remove(); }, 350);
                    } else {
                        Toast.fire({ icon: 'error', title: (d && d.message) || 'Could not delete part.' });
                    }
                },
                error: function () {
                    Toast.fire({ icon: 'error', title: 'Server error.' });
                }
            });
        });
    });

    /* ── Enter on search input submits the filter form ── */
    $(document).on('keypress', '#spFilterForm input[name="search"]', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#spFilterForm').trigger('submit');
        }
    });

    /* ── Select2 init ── */
    $(function () {
        if ($.fn.select2) {
            $('#add_category_id').select2({
                dropdownParent: $('#addPartModal'),
                width: '100%',
                placeholder: '— Select Category —',
                allowClear: true
            });
            $('#edit_category_id').select2({
                dropdownParent: $('#editPartModal'),
                width: '100%',
                placeholder: '— Select Category —',
                allowClear: true
            });
        }
    });

}());
