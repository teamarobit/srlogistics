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

    /* ─────────────────────────────────────────────────────
       Single date picker — init on any .lr-datepicker input
       Called on page load + after each new row is added.
    ───────────────────────────────────────────────────── */
    function initDatepickers($scope) {
        $scope.find('.lr-datepicker').each(function () {
            /* Skip if already initialised */
            if ($(this).data('daterangepicker')) { return; }
            $(this).daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                autoApply: true,
                opens: 'left',
                locale: {
                    format: 'DD MMM YYYY',
                    cancelLabel: 'Clear'
                }
            });
            $(this).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD MMM YYYY'));
            });
            $(this).on('cancel.daterangepicker', function () {
                $(this).val('');
            });
        });
    }

    /* Init on page load — header date + first item row */
    initDatepickers($(document));

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
        initDatepickers($newRow);
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

        /* PROTOTYPE: redirect to print page (no backend yet) */
        window.location.href = '/lr/print';
    });

});
