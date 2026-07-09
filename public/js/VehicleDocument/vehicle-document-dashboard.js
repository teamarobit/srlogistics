/**
 * SR Logistics — All Vehicle Document Dashboard
 * File: public/js/VehicleDocument/vehicle-document-dashboard.js
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

    var $form = $('#vddFilterForm');

    // ── SD-13 — Text inputs submit on Enter only ─────────────────────────
    $('#vddVehicleNumber, #vddOwnerName').on('keypress', function (e) {
        if (e.which === 13) { e.preventDefault(); $form.submit(); }
    });

    // ── SD-13 — Select2 init + auto-submit on change ─────────────────────
    var selects = [
        { id: '#vddTrackingGroup', ph: 'All Groups'    },
        { id: '#vddDocumentType',  ph: 'All Documents' }
    ];

    $.each(selects, function (i, s) {
        var $el = $(s.id);
        if ($el.length) {
            $el.select2({ width: '100%', placeholder: s.ph, allowClear: true });
            $el.on('change', function () { $form.submit(); });
        }
    });

});
