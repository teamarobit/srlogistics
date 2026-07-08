/**
 * SR Logistics — Challan Dashboard
 * File: public/js/Challan/challan-dashboard.js
 * Version: 1.2
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

    // ── Search box — submit on Enter ─────────────────────────────────────
    $('#chdSearch').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#chdFilterForm').submit(); }
    });

    // ── Text inputs — submit on Enter ────────────────────────────────────
    $('#chdVehicle, #chdDriver').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#chdFilterForm').submit(); }
    });

    // ── Select2 init + auto-submit on change (RULE 13) ───────────────────
    var selects = [
        { id: '#chdTrackingGroup', ph: 'All Groups'      },
        { id: '#chdRag',           ph: 'All RAG'         },
        { id: '#chdState',         ph: 'All States'      },
        { id: '#chdStatus',        ph: 'All Status'      },
        { id: '#chdType',          ph: 'Online & Court'  },
        { id: '#chdBorneBy',       ph: 'All'             }
    ];
    $.each(selects, function (i, s) {
        var $el = $(s.id);
        if ($el.length) {
            $el.select2({ width: '100%', placeholder: s.ph, allowClear: true });
            $el.on('change', function () { $('#chdFilterForm').submit(); });
        }
    });

    // ── Date range picker — submit on apply, clear on cancel ─────────────
    if ($('#chdDateRange').length) {
        $('#chdDateRange').on('apply.daterangepicker', function () {
            $('#chdFilterForm').submit();
        });
        $('#chdDateRange').on('cancel.daterangepicker', function () {
            $(this).val('');
            $('#chdFilterForm').submit();
        });
    }

    // ── Column-wise sorting — click a header to sort asc / desc ──────────
    // Sortable columns declare data-sort-key (matches the <tr> data-* attr)
    // and data-sort-type ("num" | "str"). Sort values live on the row as
    // data-amount (numeric) and data-date (ISO yyyy-mm-dd), never the
    // rendered "₹ 1,23,456" / "04 Feb 2026" display strings.
    var chdSortKey = 'date';   // default column
    var chdSortDir = 'desc';   // default direction — latest to old

    function chdRenumber() {
        $('#chdTableBody tr').each(function (i) {
            $(this).find('td.chd-sl').first().text(i + 1);
        });
    }

    function chdSortIcons() {
        $('#chdTable thead th.chd-sortable').each(function () {
            var $th  = $(this);
            var $ico = $th.find('.chd-sort-icon');
            var idx  = $th.index();

            $('#chdTableBody tr').each(function () {
                $(this).find('td').eq(idx).removeClass('is-sorted-col');
            });

            if ($th.data('sort-key') === chdSortKey) {
                $th.addClass('is-sorted');
                $ico.attr('class', 'uil chd-sort-icon ' + (chdSortDir === 'asc' ? 'uil-sort-amount-up' : 'uil-sort-amount-down'));
                $('#chdTableBody tr').each(function () {
                    $(this).find('td').eq(idx).addClass('is-sorted-col');
                });
            } else {
                $th.removeClass('is-sorted');
                $ico.attr('class', 'uil uil-sort chd-sort-icon');
            }
        });
    }

    function chdSortTable() {
        var $body = $('#chdTableBody');
        if (!$body.length) { return; }

        var $th   = $('#chdTable thead th.chd-sortable[data-sort-key="' + chdSortKey + '"]');
        var type  = $th.data('sort-type') || 'str';
        var dir   = (chdSortDir === 'asc') ? 1 : -1;
        var rows  = $body.find('tr').get();

        rows.sort(function (a, b) {
            var va = $(a).data(chdSortKey);
            var vb = $(b).data(chdSortKey);

            if (type === 'num') {
                return ((parseFloat(va) || 0) - (parseFloat(vb) || 0)) * dir;
            }
            va = String(va || '');
            vb = String(vb || '');
            if (va === vb) { return 0; }
            return (va < vb ? -1 : 1) * dir;
        });

        $body.append(rows);
        chdRenumber();
        chdSortIcons();
    }

    $('#chdTable').on('click', 'thead th.chd-sortable', function () {
        var key = $(this).data('sort-key');
        if (key === chdSortKey) {
            chdSortDir = (chdSortDir === 'asc') ? 'desc' : 'asc';   // toggle
        } else {
            chdSortKey = key;
            chdSortDir = 'desc';   // first click on a new column = highest / latest first
        }
        chdSortTable();
    });

    if ($('#chdTable').length) {
        chdSortTable(); // apply the default sort on load
    }

    // ── Header actions (static — no backend yet) ─────────────────────────
    $('#chdAddChallan').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Add Challan form coming soon.' });
    });

    $('#chdAutoFetch').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Auto fetch will pull challans from Parivahan / VAHAN.' });
    });

    // ── Details modal — fill from the clicked row ─────────────────────────
    $('#chdDetailModal').on('show.bs.modal', function (event) {
        var btn = $(event.relatedTarget);
        if (!btn.length) { return; }

        $('#chdModalChallan').text('Challan — ' + (btn.data('challan') || ''));
        $('#chdModalMeta').text((btn.data('vehicle') || '') + ' · ' + (btn.data('driver') || ''));

        $('#chdModalAmount').text(btn.data('amount') || '—');
        $('#chdModalStatus').text(btn.data('status') || '—');
        $('#chdModalType').text(btn.data('type') || '—');
        $('#chdModalOffence').text(btn.data('offence') || '—');

        $('#chdModalCourt').text(btn.data('court') || '—');
        $('#chdModalCourtOn').text(btn.data('courton') || '—');
        $('#chdModalCourtName').text(btn.data('courtname') || '—');
        $('#chdModalCourtAddress').text(btn.data('courtaddress') || '—');
        $('#chdModalProceeding').text(btn.data('proceeding') || '—');
        $('#chdModalVirtual').text(btn.data('virtual') || '—');
    });

});
