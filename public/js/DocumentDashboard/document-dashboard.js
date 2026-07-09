/* =============================================================
   SR Logistics — Document Dashboard — LAZY TAB LOADER
   File: public/js/DocumentDashboard/document-dashboard.js
   ─────────────────────────────────────────────────────────────
   The server renders empty .tab-pane shells only (each with
   data-tab-key + data-tab-url) plus a loading spinner. After the
   page loads, the active tab is fetched over AJAX; every other tab
   is fetched the first time it is activated. Idempotent per tab.
   ============================================================= */
(function () {
    'use strict';

    var loaded = {};   /* tab key -> true once successfully fetched */

    function loadTab($pane) {
        if (!$pane || !$pane.length) { return; }
        var key = $pane.data('tab-key');
        if (!key || loaded[key]) { return; }       /* missing key or already loaded */
        loaded[key] = true;

        $.ajax({
            url: $pane.data('tab-url'),
            method: 'GET',
            success: function (html) {
                $pane.html(html);
            },
            error: function () {
                loaded[key] = false;               /* allow a retry */
                $pane.html(
                    '<div class="docd-tab-error text-center text-danger py-5">' +
                    '<i class="uil uil-exclamation-triangle me-1"></i>' +
                    'Could not load this tab. <a href="#" class="docd-tab-retry">Retry</a>' +
                    '</div>'
                );
            }
        });
    }

    /* Lazy-load on every tab activation (user clicks). */
    $(document).on('show.bs.tab', '#docdTab button[data-bs-toggle="pill"]', function () {
        var target = $(this).attr('data-bs-target');
        if (target) { loadTab($(target)); }
    });

    /* Manual retry after a failed load. */
    $(document).on('click', '.docd-tab-retry', function (e) {
        e.preventDefault();
        loadTab($(this).closest('.tab-pane'));
    });

    /* Auto-fetch the active (first) tab after page load. */
    $(document).ready(function () {
        loadTab($('#docdTabContent > .tab-pane.active').first());
    });
})();
