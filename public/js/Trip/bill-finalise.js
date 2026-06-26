/* ============================================================
   Trip — Finalise Bill (standalone invoice / print page)
   Handles Back + Print actions. No inline JS in the blade (SD-1).
   ============================================================ */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var backBtn  = document.getElementById('bfBack');
        var printBtn = document.getElementById('bfPrint');

        if (backBtn) {
            backBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (window.history.length > 1) {
                    window.history.back();
                } else if (backBtn.dataset.fallback) {
                    window.location.href = backBtn.dataset.fallback;
                }
            });
        }

        if (printBtn) {
            printBtn.addEventListener('click', function (e) {
                e.preventDefault();
                window.print();
            });
        }
    });
})();
