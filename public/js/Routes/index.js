$(document).ready(function(){

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

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    $('#search_route, #search_source, #search_destination, #route_type, #search_status').on('change blur', function () {
        $('#searchform').submit();
    });

    // Render Tollstation list inside the modal
    $(document).on('click', '.toll-detail-btn', function () {

        var items = $(this).data('items') || [];
        var rows  = '';

        if (items.length === 0) {

            rows = '<tr><td colspan="6" class="text-center">No Data Found!</td></tr>';

        } else {

            $.each(items, function (idx, item) {
                rows += '<tr>'
                     +    '<td>' + (idx + 1) + '</td>'
                     +    '<td><span class="tag">' + (item.station_name || '-') + '</span></td>'
                     +    '<td>' + (item.toll_company  || '-') + '</td>'
                     +    '<td class="text-end">₹ ' + (item.large  || '0.00') + '</td>'
                     +    '<td class="text-end">₹ ' + (item.medium || '0.00') + '</td>'
                     +    '<td class="text-end">₹ ' + (item.small  || '0.00') + '</td>'
                     +  '</tr>';
            });
        }

        $('#tollstationListBody').html(rows);
    });

    // Render RTO Checkpoint list inside the modal
    $(document).on('click', '.rto-detail-btn', function () {

        var items = $(this).data('items') || [];
        var rows  = '';

        if (items.length === 0) {

            rows = '<tr><td colspan="6" class="text-center">No Data Found!</td></tr>';

        } else {

            $.each(items, function (idx, item) {
                rows += '<tr>'
                     +    '<td>' + (idx + 1) + '</td>'
                     +    '<td><span class="tag">' + (item.name  || '-') + '</span></td>'
                     +    '<td>' + (item.rtono || '-') + '</td>'
                     +    '<td class="text-end">₹ ' + (item.large  || '0.00') + '</td>'
                     +    '<td class="text-end">₹ ' + (item.medium || '0.00') + '</td>'
                     +    '<td class="text-end">₹ ' + (item.small  || '0.00') + '</td>'
                     +  '</tr>';
            });
        }

        $('#rtoListBody').html(rows);
    });

    $(document.body).on('click', '.delete-route', function () {
        var routeid = $(this).data('id');
        var deleteUrl = $('table.invoice-table').data('delete-url');

        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Are you sure to delete?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete.',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger btn-lg me-2',
                cancelButton: 'btn btn-secondary btn-lg me-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', routeid);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: deleteUrl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        location.reload(true);
                    },
                    error: function (xhr) {
                        var response = $.parseJSON(xhr.responseText);
                        Toast.fire({
                            icon: 'error',
                            title: response.message || 'An error occurred.'
                        });
                    }
                });
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'No action taken.'
                });
            }
        });
    });

});


