/* =============================================================
   TRIP SHOW-V2 — LAZY TAB LOADER
   ─────────────────────────────────────────────────────────────
   The server renders NO tab content — only empty .tab-pane shells
   (each with data-tab-key + data-tab-url) plus a loading spinner.
   So the initial page weight is constant no matter how heavy any
   tab becomes once it is wired to live data.

   After the page loads, this loader fetches the ACTIVE tab over
   AJAX (the remembered last tab, or the default first tab if there
   is none). Every other tab is then fetched the first time it is
   activated. After injection it re-inits the widgets show-v2.js
   wires on DOM ready (Bootstrap tooltips + the vehAlloc Select2
   dropdowns), so existing behaviour is preserved.

   This file is additive — it does NOT modify customjs/trip/show-v2.js.
   ============================================================= */
(function () {
    'use strict';

    var TAB_STORAGE_KEY = 'td2_active_tab_' + window.location.pathname; /* same key show-v2.js uses */
    var loaded = {};   /* tab key -> true once successfully fetched */

    /* Re-run the same widget inits show-v2.js does on DOM ready,
       scoped to the freshly injected pane. */
    function initPaneWidgets($pane) {
        $pane.find('[data-bs-toggle="tooltip"]').each(function () {
            if (window.bootstrap && !bootstrap.Tooltip.getInstance(this)) {
                new bootstrap.Tooltip(this);
            }
        });

        var selects = {
            '#td2OwnVehSelect'    : 'Select vehicle...',
            '#td2ExtVendorSelect' : 'Select vendor...',
            '#td2ExtVehicleSelect': 'Select vehicle...'
        };
        $.each(selects, function (sel, ph) {
            var $el = $pane.find(sel);
            if ($el.length && !$el.hasClass('select2-hidden-accessible')) {
                $el.select2({ placeholder: ph, width: '100%', allowClear: true });
            }
        });
    }

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
                initPaneWidgets($pane);
                /* Notify show-v2.js that a pane mounted (additive — lets it
                   render dynamic content like the Status Timeline entries). */
                $(document).trigger('td2:tab-loaded', [key, $pane]);
            },
            error: function () {
                loaded[key] = false;               /* allow a retry */
                $pane.html(
                    '<div class="td2-tab-error text-center text-danger py-5">' +
                    '<i class="uil uil-exclamation-triangle me-1"></i>' +
                    'Could not load this tab. <a href="#" class="td2-tab-retry">Retry</a>' +
                    '</div>'
                );
            }
        });
    }

    /* Resolve which pane is active at first paint — mirrors the logic in
       show-v2.js restoreActiveTab(): a remembered + still-visible tab wins,
       otherwise the default-active pane (first tab). Visibility is read AFTER
       show-v2.js has applied its conditional rules (it runs first by include order). */
    function resolveInitialPane() {
        var saved = sessionStorage.getItem(TAB_STORAGE_KEY);
        if (saved) {
            var $btn = $('#td2Tab button[data-bs-target="' + saved + '"]');
            if ($btn.length && $btn.closest('li').is(':visible')) {
                return $(saved);
            }
        }
        var $active = $('#td2TabContent > .tab-pane.active').first();
        if ($active.length) { return $active; }
        var $firstBtn = $('#td2Tab li:visible button[data-bs-toggle="pill"]').first();
        return $firstBtn.length ? $($firstBtn.attr('data-bs-target')) : $();
    }

    /* Lazy-load on every tab activation — covers user clicks AND the
       restoreActiveTab() call in show-v2.js (both fire show.bs.tab). */
    $(document).on('show.bs.tab', '#td2Tab button[data-bs-toggle="pill"]', function () {
        var target = $(this).attr('data-bs-target');
        if (target) { loadTab($(target)); }
    });

    /* Manual retry after a failed load */
    $(document).on('click', '.td2-tab-retry', function (e) {
        e.preventDefault();
        loadTab($(this).closest('.tab-pane'));
    });

    /* Auto-fetch the active tab after page load. Runs after show-v2.js's
       ready (include order), so conditional rules + restoreActiveTab have
       already run; loadTab() is idempotent, so a remembered tab already
       triggered by restoreActiveTab is not fetched twice. */
    $(document).ready(function () {
        loadTab(resolveInitialPane());
    });
})();
