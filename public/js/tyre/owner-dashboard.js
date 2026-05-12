/**
 * SR Logistics — Tyre Owner Dashboard
 * File: public/js/tyre/owner-dashboard.js
 * Version: 1.0
 * SD-1: All JS here — zero inline scripts in Blade.
 * SD-3: jQuery $.ajax() for filter refresh.
 * SD-7: Toast.fire() for all notifications.
 */

/* ── Toast (SD-7) ──────────────────────────────────────────────────────── */
const Toast = Swal.mixin({
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

    /* ── Filter Form Submit (SD-3) ──────────────────────────────────────── */
    $('#tod-filter-form').on('submit', function (e) {
        e.preventDefault();
        var dateFrom = $('#filter_date_from').val();
        var dateTo   = $('#filter_date_to').val();

        if (dateFrom && dateTo && dateFrom > dateTo) {
            Toast.fire({ icon: 'error', title: 'Date From cannot be after Date To.' });
            return;
        }

        // Submit as GET page reload with query params
        var params = $(this).serialize();
        window.location.href = window.location.pathname + '?' + params;
    });

    /* ── Reset Filters ─────────────────────────────────────────────────── */
    $('#tod-filter-reset').on('click', function () {
        window.location.href = window.location.pathname;
    });

    /* ── Animate KPI number counters on page load ───────────────────────── */
    animateCounters();

    /* ── KM Progress bar widths (set via data-pct) ─────────────────────── */
    $('.km-bar-fill').each(function () {
        var pct = parseFloat($(this).data('pct')) || 0;
        pct = Math.min(100, Math.max(0, pct));
        $(this).css('width', pct + '%');
    });

    /* ── Tooltip init ──────────────────────────────────────────────────── */
    if (typeof $.fn.tooltip !== 'undefined') {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

});

/**
 * Animate number counters — targets elements with class .tod-count-animate
 * Reads data-target for final value.
 */
function animateCounters() {
    $('.tod-count-animate').each(function () {
        var $el      = $(this);
        var target   = parseFloat($el.data('target')) || 0;
        var isFloat  = $el.data('float') === true || $el.data('float') === 'true';
        var prefix   = $el.data('prefix') || '';
        var suffix   = $el.data('suffix') || '';
        var duration = 800;
        var start    = 0;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased    = 1 - Math.pow(1 - progress, 3); // ease-out cubic
            var current  = eased * target;
            if (isFloat) {
                $el.text(prefix + formatIndianCurrency(current) + suffix);
            } else {
                $el.text(prefix + Math.floor(current) + suffix);
            }
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                if (isFloat) {
                    $el.text(prefix + formatIndianCurrency(target) + suffix);
                } else {
                    $el.text(prefix + Math.floor(target) + suffix);
                }
            }
        }

        requestAnimationFrame(step);
    });
}

/**
 * Format number as Indian currency (lakhs/crores) — e.g. 1,23,456.00
 */
function formatIndianCurrency(num) {
    if (isNaN(num)) return '0.00';
    num = parseFloat(num).toFixed(2);
    var parts = num.toString().split('.');
    var intPart = parts[0];
    var decPart = parts[1] || '00';
    // Indian numbering: last 3 digits, then groups of 2
    if (intPart.length > 3) {
        var lastThree = intPart.substring(intPart.length - 3);
        var remaining = intPart.substring(0, intPart.length - 3);
        lastThree = remaining.length > 0
            ? remaining.replace(/\B(?=(\d{2})+(?!\d))/g, ',') + ',' + lastThree
            : lastThree;
        intPart = lastThree;
    }
    return intPart + '.' + decPart;
}
