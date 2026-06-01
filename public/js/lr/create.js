/* =========================================================
   LR Create — create.js  v2.0
   SR Logistics — Lorry Receipt create page
   Redesigned: 2026-06-01
   Rules: SD-1 (no inline JS) · SD-3 ($.ajax) · SD-7 (Toast)
   ========================================================= */

/* ── SD-7: Toast mixin ───────────────────────────────────── */
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

$(document).ready(function () {

    /* ── bootstrap-tagsinput init (Seal Numbers) ──────── */
    if ($('#lr_seal_number').length && typeof $.fn.tagsinput === 'function') {
        $('#lr_seal_number').tagsinput({
            trimValue: true,
            confirmKeys: [13, 44]   /* Enter or comma */
        });
    }

    /* ── Row index counter (row 0 pre-rendered in HTML) ── */
    var itemRowCount = 1;

    /* ─────────────────────────────────────────────────────
       Renumber all rows S.N column (1, 2, 3…)
    ───────────────────────────────────────────────────── */
    function renumberRows() {
        $('#lr-items-tbody tr').each(function (idx) {
            $(this).find('.lr-sn').text(idx + 1);
        });
    }

    /* ─────────────────────────────────────────────────────
       Recalculate freight total
    ───────────────────────────────────────────────────── */
    function recalcTotal() {
        var total = 0;
        $('#lr-items-tbody .lr-freight-input').each(function () {
            var val = parseFloat($(this).val()) || 0;
            total += val;
        });
        $('#lr-freight-total').text(total.toFixed(2));
    }

    /* ─────────────────────────────────────────────────────
       Live total on freight input change
    ───────────────────────────────────────────────────── */
    $('#lr-items-tbody').on('input', '.lr-freight-input', function () {
        recalcTotal();
    });

    /* ─────────────────────────────────────────────────────
       Add Item row
    ───────────────────────────────────────────────────── */
    $('#lr-add-item').on('click', function () {
        var $newRow = $('#lr-items-tbody tr:first').clone(false);

        /* Clear all inputs / textareas */
        $newRow.find('input').val('');
        $newRow.find('textarea').val('');

        /* Update name[] indices to new row index */
        $newRow.find('[name]').each(function () {
            var name = $(this).attr('name').replace(/\[\d+\]/, '[' + itemRowCount + ']');
            $(this).attr('name', name);
        });

        /* Add delete icon (first row has no icon) */
        $newRow.find('.lr-delete-wrap').html(
            '<i class="uil uil-trash-alt lr-delete-row" title="Remove row"></i>'
        );

        $('#lr-items-tbody').append($newRow);
        itemRowCount++;
        renumberRows();
        recalcTotal();
    });

    /* ─────────────────────────────────────────────────────
       Delete row (event delegation — rows added dynamically)
    ───────────────────────────────────────────────────── */
    $('#lr-items-tbody').on('click', '.lr-delete-row', function () {
        if ($('#lr-items-tbody tr').length <= 1) {
            Toast.fire({ icon: 'warning', title: 'At least one item row is required.' });
            return;
        }
        $(this).closest('tr').remove();
        renumberRows();
        recalcTotal();
    });

    /* ─────────────────────────────────────────────────────
       SD-3: Form submit via $.ajax()
       ACTION NOTE: Set form action to route('trip.lr.store')
       once that route is created in routes/web.php.
    ───────────────────────────────────────────────────── */
    $('#lrCreateForm').on('submit', function (e) {
        e.preventDefault();

        var $form = $(this);
        var storeUrl = $form.attr('action');

        /* Abort if placeholder action — route not yet created */
        if (!storeUrl || storeUrl === '#') {
            Toast.fire({ icon: 'error', title: 'Store route not configured yet.' });
            return;
        }

        /* Clear previous inline errors */
        $('.lr-field-error').text('');

        var $btn = $('#lr-save-btn');
        $btn.prop('disabled', true).text('Saving…');

        $.ajax({
            url: storeUrl,
            method: 'POST',
            data: $form.serialize(),
            success: function (res) {
                if (res.success) {
                    Toast.fire({ icon: 'success', title: res.message || 'LR saved successfully.' });
                    if (res.redirect) {
                        setTimeout(function () { window.location.href = res.redirect; }, 1000);
                    }
                } else {
                    Toast.fire({ icon: 'error', title: res.message || 'Failed to save LR.' });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
                        $('#err-' + field).text(messages[0]);
                    });
                    Toast.fire({ icon: 'error', title: 'Please fix the highlighted errors.' });
                } else {
                    Toast.fire({ icon: 'error', title: 'Something went wrong. Please try again.' });
                }
            },
            complete: function () {
                $btn.prop('disabled', false).text('Save LR');
            }
        });
    });

});
