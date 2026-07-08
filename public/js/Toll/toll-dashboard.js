/**
 * SR Logistics — Toll Dashboard
 * File: public/js/Toll/toll-dashboard.js
 * Version: 1.0
 */

$(function () {

    // ── Search box — submit on Enter ─────────────────────────────────────
    $('#tldSearch').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#tldFilterForm').submit(); }
    });

    // ── Text inputs — submit on Enter ────────────────────────────────────
    $('#tldFastagId, #tldVehicle, #tldDriver').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#tldFilterForm').submit(); }
    });

    // ── Select2 init + auto-submit on change ─────────────────────────────
    var selects = [
        { id: '#tldBank',    ph: 'All Banks'  },
        { id: '#tldRoute',   ph: 'All Routes' },
        { id: '#tldDispute', ph: 'All'        }
    ];
    $.each(selects, function (i, s) {
        var $el = $(s.id);
        if ($el.length) {
            $el.select2({ width: '100%', placeholder: s.ph, allowClear: true });
            $el.on('change', function () { $('#tldFilterForm').submit(); });
        }
    });

    // ── Date range picker — submit on apply, clear on cancel ─────────────
    if ($('#tldDateRange').length) {
        $('#tldDateRange').on('apply.daterangepicker', function () {
            $('#tldFilterForm').submit();
        });
        $('#tldDateRange').on('cancel.daterangepicker', function () {
            $(this).val('');
            $('#tldFilterForm').submit();
        });
    }

    // ── View details modal — fill header from the clicked row ────────────
    $('#tldDetailModal').on('show.bs.modal', function (event) {
        var btn     = $(event.relatedTarget);
        var vehicle = btn.data('vehicle');
        var fastag  = btn.data('fastag');
        var bank    = btn.data('bank');
        if (vehicle) {
            $('#tldModalVehicle').text('Toll Transactions — ' + vehicle);
            $('#tldModalMeta').text('FASTag ' + fastag + ' · ' + bank);
        }
    });

});
