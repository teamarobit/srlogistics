/**
 * Vehicle Document Expiry — page filters (SD-1: external JS only)
 * Triggers: doc type change, expiry filter change, search Enter, reset button click.
 */
(function () {
    'use strict';

    var baseUrl = $('#deUrls').data('base-url');

    function applyFilters() {
        var params = new URLSearchParams();
        var s  = $.trim($('#searchInput').val());
        var dt = $('#docTypeFilter').val();
        var ef = $('#expiryFilter').val();
        if (s)  params.set('search', s);
        if (dt) params.set('doc_type', dt);
        if (ef) params.set('expiry_filter', ef);
        window.location = baseUrl + (params.toString() ? '?' + params.toString() : '');
    }

    function resetFilters() {
        window.location = baseUrl;
    }

    $(function () {
        $('#docTypeFilter').on('change', applyFilters);
        $('#expiryFilter').on('change', applyFilters);
        $('#searchInput').on('keydown', function (e) {
            if (e.key === 'Enter') applyFilters();
        });
        $('#searchInput').on('blur', function () {
            var current = new URLSearchParams(window.location.search).get('search') || '';
            if ($.trim($(this).val()) !== current) applyFilters();
        });
        $('#searchBtn').on('click', applyFilters);
        $('#resetBtn').on('click', resetFilters);
    });
})();
