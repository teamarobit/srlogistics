// Employee Exit & Clearance Letter — standalone page JS
// SD-1: no inline JS in blade; print handler lives here.
document.addEventListener('DOMContentLoaded', function () {
    var printBtn = document.getElementById('printExitLetterBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function () {
            window.print();
        });
    }
});
