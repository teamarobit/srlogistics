/**
 * SR Logistics — Escalation Dashboard
 * File: public/js/Escalation/escalation-dashboard.js
 * Version: 1.0
 *
 * Static screen — no backend wiring yet.
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

    // ── Name text input — submit on Enter only (RULE 13) ─────────────────
    $('#esdName').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#esdFilterForm').submit(); }
    });

    // ── Select2 init + auto-submit on change (RULE 13) ───────────────────
    var esdSelects = [
        { id: '#esdFor',       ph: 'All Types'      },
        { id: '#esdRag',       ph: 'All RAG'        },
        { id: '#esdPriority',  ph: 'All Priority'   },
        { id: '#esdAllocated', ph: 'All Members'    },
        { id: '#esdStatus',    ph: 'Open & Closed'  }
    ];
    $.each(esdSelects, function (i, s) {
        var $el = $(s.id);
        if ($el.length) {
            $el.select2({ width: '100%', placeholder: s.ph, allowClear: true });
            $el.on('change', function () { $('#esdFilterForm').submit(); });
        }
    });

    // ── Column-wise sorting ──────────────────────────────────────────────
    // Sortable <th> declares data-sort-key (matches the <tr> data-* attr) and
    // data-sort-type ("num" | "str"). Sort values live on the row as
    // data-name (string), data-rag (3=Red 2=Amber 1=Green) and
    // data-priority (3=High 2=Medium 1=Low) — never the display strings.
    var esdSortKey = 'rag';    // default column
    var esdSortDir = 'desc';   // default direction — Red first

    function esdRenumber() {
        $('#esdTableBody tr').each(function (i) {
            $(this).find('td.esd-sl').first().text(i + 1);
        });
    }

    function esdSortIcons() {
        $('#esdTable thead th.esd-sortable').each(function () {
            var $th  = $(this);
            var $ico = $th.find('.esd-sort-icon');
            var idx  = $th.index();

            $('#esdTableBody tr').each(function () {
                $(this).find('td').eq(idx).removeClass('is-sorted-col');
            });

            if ($th.data('sort-key') === esdSortKey) {
                $th.addClass('is-sorted');
                $ico.attr('class', 'uil esd-sort-icon ' + (esdSortDir === 'asc' ? 'uil-sort-amount-up' : 'uil-sort-amount-down'));
                $('#esdTableBody tr').each(function () {
                    $(this).find('td').eq(idx).addClass('is-sorted-col');
                });
            } else {
                $th.removeClass('is-sorted');
                $ico.attr('class', 'uil uil-sort esd-sort-icon');
            }
        });
    }

    function esdSortTable() {
        var $body = $('#esdTableBody');
        if (!$body.length) { return; }

        var $th  = $('#esdTable thead th.esd-sortable[data-sort-key="' + esdSortKey + '"]');
        var type = $th.data('sort-type') || 'str';
        var dir  = (esdSortDir === 'asc') ? 1 : -1;
        var rows = $body.find('tr').get();

        rows.sort(function (a, b) {
            var va = $(a).data(esdSortKey);
            var vb = $(b).data(esdSortKey);

            if (type === 'num') {
                return ((parseFloat(va) || 0) - (parseFloat(vb) || 0)) * dir;
            }
            va = String(va || '').toLowerCase();
            vb = String(vb || '').toLowerCase();
            if (va === vb) { return 0; }
            return (va < vb ? -1 : 1) * dir;
        });

        $body.append(rows);
        esdRenumber();
        esdSortIcons();
    }

    $('#esdTable').on('click', 'thead th.esd-sortable', function () {
        var key = $(this).data('sort-key');
        if (key === esdSortKey) {
            esdSortDir = (esdSortDir === 'asc') ? 'desc' : 'asc';   // toggle
        } else {
            esdSortKey = key;
            esdSortDir = 'desc';   // first click on a new column = highest first
        }
        esdSortTable();
    });

    if ($('#esdTable').length) {
        esdSortTable(); // apply the default sort on load
    }

    // ── Header actions (static — no backend yet) ─────────────────────────
    $('#esdAddEscalation').on('click', function () {
        Toast.fire({ icon: 'info', title: 'Add Escalation form coming soon.' });
    });

});
