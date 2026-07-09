/**
 * SR Logistics — EMI Dashboard
 * File: public/js/Emi/emi-dashboard.js
 * Version: 1.0
 */

// SD-7 — Toast mixin (one per JS file)
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

    // ── Text inputs — submit on Enter (RULE 13) ──────────────────────────
    $('#emidVehicle').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#emidFilterForm').submit(); }
    });

    // ── Select2 init + auto-submit on change (RULE 13) ───────────────────
    var selects = [
        { id: '#emidStatus',   ph: 'All Status'     },
        { id: '#emidFinancer', ph: 'All Financers'  },
        { id: '#emidDate',     ph: 'All Dates'      },
        { id: '#emidLoanType', ph: 'All Loan Types' }
    ];
    $.each(selects, function (i, s) {
        var $el = $(s.id);
        if ($el.length) {
            $el.select2({ width: '100%', placeholder: s.ph, allowClear: true });
            $el.on('change', function () { $('#emidFilterForm').submit(); });
        }
    });

    // ── Column-wise sorting — click a header to sort asc / desc ──────────
    // Sortable columns declare data-sort-key (matches the <tr> data-* attr)
    // and data-sort-type ("num" | "str"). Sort values live on the row as
    // data-emidate, data-emiamt, data-progress, data-roi, data-loanamt —
    // never the rendered "₹ 58,400" / "10 / 36" display strings.
    var emidSortKey = 'emidate';   // default column
    var emidSortDir = 'asc';       // default direction — 1st, 5th, 10th

    function emidRenumber() {
        $('#emidTableBody tr').each(function (i) {
            $(this).find('td.emid-sl').first().text(i + 1);
        });
    }

    function emidSortIcons() {
        $('#emidTable thead th.emid-sortable').each(function () {
            var $th  = $(this);
            var $ico = $th.find('.emid-sort-icon');
            var idx  = $th.index();

            $('#emidTableBody tr').each(function () {
                $(this).find('td').eq(idx).removeClass('is-sorted-col');
            });

            if ($th.data('sort-key') === emidSortKey) {
                $th.addClass('is-sorted');
                $ico.attr('class', 'uil emid-sort-icon ' + (emidSortDir === 'asc' ? 'uil-sort-amount-up' : 'uil-sort-amount-down'));
                $('#emidTableBody tr').each(function () {
                    $(this).find('td').eq(idx).addClass('is-sorted-col');
                });
            } else {
                $th.removeClass('is-sorted');
                $ico.attr('class', 'uil uil-sort emid-sort-icon');
            }
        });
    }

    function emidSortTable() {
        var $body = $('#emidTableBody');
        if (!$body.length) { return; }

        var $th  = $('#emidTable thead th.emid-sortable[data-sort-key="' + emidSortKey + '"]');
        var type = $th.data('sort-type') || 'str';
        var dir  = (emidSortDir === 'asc') ? 1 : -1;
        var rows = $body.find('tr').get();

        rows.sort(function (a, b) {
            var va = $(a).data(emidSortKey);
            var vb = $(b).data(emidSortKey);

            if (type === 'num') {
                return ((parseFloat(va) || 0) - (parseFloat(vb) || 0)) * dir;
            }
            va = String(va || '');
            vb = String(vb || '');
            if (va === vb) { return 0; }
            return (va < vb ? -1 : 1) * dir;
        });

        $body.append(rows);
        emidRenumber();
        emidSortIcons();
    }

    $('#emidTable').on('click', 'thead th.emid-sortable', function () {
        var key = $(this).data('sort-key');
        if (key === emidSortKey) {
            emidSortDir = (emidSortDir === 'asc') ? 'desc' : 'asc';   // toggle
        } else {
            emidSortKey = key;
            emidSortDir = 'desc';   // first click on a new column = highest first
        }
        emidSortTable();
    });

    if ($('#emidTable').length) {
        emidSortTable(); // apply the default sort on load
    }

    // ── Header + row actions (static — no backend yet) ───────────────────
    $('#emidAddEmi').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Add EMI form coming soon.' });
    });

    $('#emidExport').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Export will download the filtered EMI records.' });
    });

    $('#emidTableBody').on('click', '.emid-attach', function (e) {
        e.preventDefault();
        Toast.fire({ icon: 'info', title: 'EMI repayment schedule download coming soon.' });
    });

});
