$(document).ready(function () {

    // ── City filter — Select2 ─────────────────────────────────────────────
    $('#spvCityFilter').select2({
        width: '100%',
        placeholder: 'Filter by City',
        allowClear: true,
    });
    $('#spvCityFilter').on('change', function () {
        $('#filterForm').submit();
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    // ── Toggle Status ─────────────────────────────────────────────────────
    $(document).on('click', '.spv-toggle', function () {
        var id      = $(this).data('id');
        var name    = $(this).data('name');
        var current = $(this).data('status');
        var action  = current === 'Active' ? 'Deactivate' : 'Activate';
        var color   = current === 'Active' ? '#ea0027' : '#10863f';

        Swal.fire({
            title: action + ' Vendor?', text: '"' + name + '"', icon: 'warning',
            showCancelButton: true, confirmButtonColor: color, confirmButtonText: action
        }).then(function (r) {
            if (!r.isConfirmed) return;
            $.ajax({
                method: 'POST',
                url: TOGGLE_BASE + id + '/toggle-status',
                data: { _token: CSRF },
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        Toast.fire({ icon: 'success', title: 'Status updated to ' + res.new_status });
                        setTimeout(function () { location.reload(); }, 1500);
                    } else {
                        Toast.fire({ icon: 'error', title: res.message || 'Failed to update status.' });
                    }
                },
                error: function () {
                    Toast.fire({ icon: 'error', title: 'Something went wrong.' });
                }
            });
        });
    });

    // ── Soft Delete (single row) ──────────────────────────────────────────
    $(document).on('click', '.spv-delete', function () {
        var id   = $(this).data('id');
        var name = $(this).data('name');
        Swal.fire({
            title: 'Delete "' + name + '"?',
            text: 'This vendor will be soft-deleted and can be restored later.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#ea0027', confirmButtonText: 'Delete'
        }).then(function (r) {
            if (!r.isConfirmed) return;
            $.ajax({
                method: 'POST',
                url: DELETE_BASE + id,
                data: { _token: CSRF, _method: 'DELETE' },
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        $('#row-' + id).fadeOut(300, function () { $(this).remove(); });
                        Toast.fire({ icon: 'success', title: 'Deleted.' });
                    } else {
                        Toast.fire({ icon: 'error', title: res.message || 'Failed to delete.' });
                    }
                },
                error: function () {
                    Toast.fire({ icon: 'error', title: 'Something went wrong.' });
                }
            });
        });
    });

    // ── Bulk Delete button visibility helper ──────────────────────────────
    function toggleBulkDeleteBtn() {
        if ($('.rowCheckbox:checked').length > 0) {
            $('#bulkDeleteBtn').show();
        } else {
            $('#bulkDeleteBtn').hide();
        }
    }

    // ── Select All checkbox ───────────────────────────────────────────────
    $(document).on('change', '#selectAll', function () {
        $('.rowCheckbox').prop('checked', this.checked);
        toggleBulkDeleteBtn();
    });

    $(document).on('change', '.rowCheckbox', function () {
        $('#selectAll').prop('checked',
            $('.rowCheckbox:checked').length === $('.rowCheckbox').length
        );
        toggleBulkDeleteBtn();
    });

    // ── Bulk Delete ───────────────────────────────────────────────────────
    $('#confirmDelete').on('click', function () {

        var type = $('input[name="deleteType"]:checked').val();

        if (type === 'selected') {

            var ids = [];
            $('.rowCheckbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                Toast.fire({ icon: 'error', title: 'Please select at least one row.' });
                return;
            }

            $.ajax({
                url: DELETE_SELECTED_CONTACT,
                type: 'POST',
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        Toast.fire({ icon: 'success', title: response.message });
                        setTimeout(function () { location.reload(); }, 1500);
                    } else {
                        Toast.fire({ icon: 'error', title: response.message });
                    }
                },
                error: function () {
                    Toast.fire({ icon: 'error', title: 'Something went wrong.' });
                }
            });

        } else if (type === 'all') {

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete all spare part vendor records.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete all!',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                var formData = $('#filterForm').serializeArray();
                formData.push({ name: 'cotype', value: CO_TYPE });
                formData.push({ name: '_token', value: $('meta[name="csrf-token"]').attr('content') });

                $.ajax({
                    url: DELETE_ALL,
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            Toast.fire({ icon: 'success', title: response.message });
                            setTimeout(function () { location.reload(); }, 1500);
                        } else {
                            Toast.fire({ icon: 'error', title: response.message });
                        }
                    },
                    error: function () {
                        Toast.fire({ icon: 'error', title: 'Something went wrong.' });
                    }
                });
            });
        }
    });

});
