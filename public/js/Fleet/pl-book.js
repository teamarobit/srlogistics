/* =====================================================
   P&L Book — Filter widgets (Select2 + Daterange)
   Scoped to #pl_book
   ===================================================== */
$(function () {
    // Driver: Select2 searchable dropdown
    if ($('#pl_driver').length) {
        $('#pl_driver').select2({
            placeholder: 'Search driver...',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#pl_book')
        });
    }

    // Date Range: project-standard daterangepicker
    // Note: layout-level auto-init already binds `.daterange`,
    // but we override here to set a default range (current month) for P&L Book.
    if ($('#pl_daterange').length) {
        var startDefault = moment().startOf('month');
        var endDefault   = moment().endOf('month');

        $('#pl_daterange').daterangepicker({
            opens: 'right',
            autoUpdateInput: true,
            startDate: startDefault,
            endDate: endDefault,
            locale: {
                format: 'DD-MM-YYYY',
                cancelLabel: 'Clear',
                separator: ' to '
            },
            ranges: {
                'Today'        : [moment(), moment()],
                'Yesterday'    : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days'  : [moment().subtract(6, 'days'), moment()],
                'This Month'   : [moment().startOf('month'),  moment().endOf('month')],
                'Last Month'   : [moment().subtract(1, 'month').startOf('month'),
                                  moment().subtract(1, 'month').endOf('month')],
                'This Quarter' : [moment().startOf('quarter'), moment().endOf('quarter')],
                'This Year'    : [moment().startOf('year'),    moment().endOf('year')]
            }
        });

        // Apply
        $('#pl_daterange').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(
                picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY')
            );
        });

        // Cancel
        $('#pl_daterange').on('cancel.daterangepicker', function () {
            $(this).val('');
        });
    }
});
