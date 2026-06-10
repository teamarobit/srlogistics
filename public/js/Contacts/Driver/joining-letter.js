// Driver Joining Letter — standalone page JS
// SD-1: no inline JS in blade; print handler lives here.
document.addEventListener('DOMContentLoaded', function () {
    var printBtn = document.getElementById('printJoiningLetterBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function () {
            window.print();
        });
    }
});
