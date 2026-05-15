/* =========================================================
   Battery Details Page — battery-details.js  v1.0
   ========================================================= */

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

$(document).ready(function () {

    // ── Movement log filter ──────────────────────────────────────────────
    $('#bdet-log-type-filter').on('change', function () {
        var val = $(this).val();
        var events = $('.bdet-tl-event');
        if (!val) {
            events.show();
            $('#bdet-log-empty').hide();
            return;
        }
        var visible = 0;
        events.each(function () {
            if ($(this).data('event-type') === val) {
                $(this).show();
                visible++;
            } else {
                $(this).hide();
            }
        });
        $('#bdet-log-empty').toggle(visible === 0);
    });

});
