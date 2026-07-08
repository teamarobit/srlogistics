/**
 * SR Logistics — Fuel Dashboard
 * File: public/js/Fuel/fuel-dashboard.js
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

    // ── Search + text inputs — submit on Enter (RULE 13) ─────────────────
    $('#fudTripId, #fudLrNumber, #fudVehicle, #fudDriver').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#fudFilterForm').submit(); }
    });

    // ── Select2 init + auto-submit on change (RULE 13) ───────────────────
    var selects = [
        { id: '#fudCompany',  ph: 'All Companies' },
        { id: '#fudLocation', ph: 'All Locations' },
        { id: '#fudPayment',  ph: 'All Methods'   }
    ];
    $.each(selects, function (i, s) {
        var $el = $(s.id);
        if ($el.length) {
            $el.select2({ width: '100%', placeholder: s.ph, allowClear: true });
            $el.on('change', function () { $('#fudFilterForm').submit(); });
        }
    });

    // ── Date range picker — submit on apply, clear on cancel ─────────────
    if ($('#fudDateRange').length) {
        $('#fudDateRange').on('apply.daterangepicker', function () {
            $('#fudFilterForm').submit();
        });
        $('#fudDateRange').on('cancel.daterangepicker', function () {
            $(this).val('');
            $('#fudFilterForm').submit();
        });
    }

    // ── Column-wise sorting — click a header to sort asc / desc ──────────
    // Sortable columns declare data-sort-key (matches the <tr> data-* attr)
    // and data-sort-type ("num" | "str"). Sort values live on the row as
    // data-date (ISO yyyy-mm-dd), data-qty, data-amount, data-rate — never
    // the rendered "₹ 19,800" / "04 Feb 2026" display strings.
    var fudSortKey = 'date';   // default column
    var fudSortDir = 'desc';   // default direction — latest to old

    function fudRenumber() {
        $('#fudTableBody tr').each(function (i) {
            $(this).find('td.fud-sl').first().text(i + 1);
        });
    }

    function fudSortIcons() {
        $('#fudTable thead th.fud-sortable').each(function () {
            var $th  = $(this);
            var $ico = $th.find('.fud-sort-icon');
            var idx  = $th.index();

            $('#fudTableBody tr').each(function () {
                $(this).find('td').eq(idx).removeClass('is-sorted-col');
            });

            if ($th.data('sort-key') === fudSortKey) {
                $th.addClass('is-sorted');
                $ico.attr('class', 'uil fud-sort-icon ' + (fudSortDir === 'asc' ? 'uil-sort-amount-up' : 'uil-sort-amount-down'));
                $('#fudTableBody tr').each(function () {
                    $(this).find('td').eq(idx).addClass('is-sorted-col');
                });
            } else {
                $th.removeClass('is-sorted');
                $ico.attr('class', 'uil uil-sort fud-sort-icon');
            }
        });
    }

    function fudSortTable() {
        var $body = $('#fudTableBody');
        if (!$body.length) { return; }

        var $th  = $('#fudTable thead th.fud-sortable[data-sort-key="' + fudSortKey + '"]');
        var type = $th.data('sort-type') || 'str';
        var dir  = (fudSortDir === 'asc') ? 1 : -1;
        var rows = $body.find('tr').get();

        rows.sort(function (a, b) {
            var va = $(a).data(fudSortKey);
            var vb = $(b).data(fudSortKey);

            if (type === 'num') {
                return ((parseFloat(va) || 0) - (parseFloat(vb) || 0)) * dir;
            }
            va = String(va || '');
            vb = String(vb || '');
            if (va === vb) { return 0; }
            return (va < vb ? -1 : 1) * dir;
        });

        $body.append(rows);
        fudRenumber();
        fudSortIcons();
    }

    $('#fudTable').on('click', 'thead th.fud-sortable', function () {
        var key = $(this).data('sort-key');
        if (key === fudSortKey) {
            fudSortDir = (fudSortDir === 'asc') ? 'desc' : 'asc';   // toggle
        } else {
            fudSortKey = key;
            fudSortDir = 'desc';   // first click on a new column = highest / latest first
        }
        fudSortTable();
    });

    if ($('#fudTable').length) {
        fudSortTable(); // apply the default sort on load
    }

    // ── Header actions (static — no backend yet) ─────────────────────────
    $('#fudAddEntry').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Add Fuel Entry form coming soon.' });
    });

    $('#fudExport').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Export will download the filtered fuel entries.' });
    });

});
