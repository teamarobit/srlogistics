/**
 * Truck Repair · Work Done "More" handler
 * Opens the #trWorkDoneModal with the full text stored in data-content.
 */
$(function () {
    $(document).on('click', '.tr-workdone-more', function () {
        var title   = $(this).data('title')   || 'Work Done';
        var content = $(this).data('content') || '';

        $('#trWorkDoneModalLabel').text(title);
        $('#trWorkDoneModalBody').text(content);

        var modalEl = document.getElementById('trWorkDoneModal');
        var modal   = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.show();
    });
});
