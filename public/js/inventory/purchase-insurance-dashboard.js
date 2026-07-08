/**
 * SR Logistics — Purchase Insurance Dashboard
 * File: public/js/Inventory/purchase-insurance-dashboard.js
 * Version: 1.1
 */

$(function () {

    // ── Vehicle number text input — submit on Enter ──────────────────────
    $('#pidVehicle').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#pidFilterForm').submit(); }
    });

    // ── Driver text input — submit on Enter ──────────────────────────────
    $('#pidDriver').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $('#pidFilterForm').submit(); }
    });

    // ── Select2 init ────────────────────────────────────────────────────
    if ($('#pidTrackingGroup').length) {
        $('#pidTrackingGroup').select2({ width: '100%', placeholder: 'All Groups', allowClear: true });
        $('#pidTrackingGroup').on('change', function () { $('#pidFilterForm').submit(); });
    }
    if ($('#pidState').length) {
        $('#pidState').select2({ width: '100%', placeholder: 'All States', allowClear: true });
        $('#pidState').on('change', function () { $('#pidFilterForm').submit(); });
    }
    if ($('#pidStatus').length) {
        $('#pidStatus').select2({ width: '100%', placeholder: 'All Statuses', allowClear: true });
        $('#pidStatus').on('change', function () { $('#pidFilterForm').submit(); });
    }
    if ($('#pidDriverMistake').length) {
        $('#pidDriverMistake').select2({ width: '100%', placeholder: 'All', allowClear: true });
        $('#pidDriverMistake').on('change', function () { $('#pidFilterForm').submit(); });
    }
    if ($('#pidFir').length) {
        $('#pidFir').select2({ width: '100%', placeholder: 'All', allowClear: true });
        $('#pidFir').on('change', function () { $('#pidFilterForm').submit(); });
    }

    // Date range picker — submit on apply, clear on cancel
    if ($('#pidDateRange').length) {
        $('#pidDateRange').on('apply.daterangepicker', function () {
            $('#pidFilterForm').submit();
        });
        $('#pidDateRange').on('cancel.daterangepicker', function () {
            $(this).val('');
            $('#pidFilterForm').submit();
        });
    }

    // ── Row "View" button — open Maintenance & Scheduled Service modal ────
    var pidMaintenanceModalEl = document.getElementById('pidMaintenanceModal');
    if (pidMaintenanceModalEl && typeof bootstrap !== 'undefined') {
        var pidMaintenanceModal = new bootstrap.Modal(pidMaintenanceModalEl);
        $(document).on('click', '.pid-view-btn', function (e) {
            e.preventDefault();
            var vehicle = $.trim($(this).closest('tr').find('.pid-reg').text());
            $('#pidMaintenanceModalMeta').text(vehicle ? 'Vehicle ' + vehicle : 'Vehicle overview');
            pidMaintenanceModal.show();
        });
    }

});
