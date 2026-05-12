/**
 * Tyre Details — Movement Log Tab JS
 * File: public/js/tyre/show.js  v1.0
 *
 * SD-1: All JS logic for the Movement Log tab lives here.
 * No inline <script> logic in the blade.
 */
$(document).ready(function () {

    // ── Movement Log type filter ──────────────────────────────────────────────
    $('#tl-log-type-filter').on('change', function () {
        var val = $(this).val();
        var $events = $('.tl-log-event');
        var $empty  = $('#tl-log-empty');

        // Show all when no filter selected
        if (!val) {
            $events.show();
            $empty.hide();
            return;
        }

        var visible = 0;
        $events.each(function () {
            var eventType = $(this).data('event-type');   // e.g. "fitment", "null", ""
            var match;

            if (val === 'null') {
                // "Created" events have no action_type (rendered as empty string or "null")
                match = !eventType || eventType === '' || eventType === 'null';
            } else {
                match = (eventType === val);
            }

            $(this).toggle(!!match);
            if (match) { visible++; }
        });

        $empty.toggle(visible === 0);
    });

});
