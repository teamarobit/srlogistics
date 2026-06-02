// Global Toast — must be visible to layout's window.onload fallback so it
// never falls back to alert() for session('error') flashes.
window.Toast = window.Toast || Swal.mixin({
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

$(document).ready(function(){

    var Toast = window.Toast;

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


    // BUG-007 — read success message handed off by create.js / edit.js via sessionStorage
    var flashKey = 'digilock_success_msg';
    var flashMsg = sessionStorage.getItem(flashKey);
    if (flashMsg) {
        Toast.fire({ icon: 'success', title: flashMsg });
        sessionStorage.removeItem(flashKey);
    }

    // BUG-003 — read flashes coming from controller redirects
    if (typeof FLASH_SUCCESS !== 'undefined' && FLASH_SUCCESS) {
        Toast.fire({ icon: 'success', title: FLASH_SUCCESS });
    }
    if (typeof FLASH_ERROR !== 'undefined' && FLASH_ERROR) {
        Toast.fire({ icon: 'error', title: FLASH_ERROR });
    }


    // Auto-submit on filter changes (kept from original; submit button now also exists)
    $('#search_status').on('change', function () {
        $('#searchform').submit();
    });


    // BUG-002 — open read-only View modal
    $(document.body).on('click', '.viewRecord', function () {
        var $btn = $(this);
        $('#view_name').text($btn.data('name') || '—');
        $('#view_code').text($btn.data('code') || '—');

        var status = $btn.data('status') || '';
        var badgeClass = status === 'Active' ? 'bg-success' : 'bg-danger';
        $('#view_status').html(status ? '<span class="badge ' + badgeClass + '">' + status + '</span>' : '—');

        var createdBy = $btn.data('createdby') || '';
        var createdEmail = $btn.data('createdemail') || '';
        var createdHtml = createdBy ? createdBy + (createdEmail ? '<span class="text-secondary d-block small">' + createdEmail + '</span>' : '') : '—';
        $('#view_createdby').html(createdHtml);

        $('#view_created').text($btn.data('created') || '—');
        $('#view_updated').text($btn.data('updated') || '—');

        var modal = new bootstrap.Modal(document.getElementById('viewProviderModal'));
        modal.show();
    });


    // BUG-001 / BUG-010 — soft-delete handler
    $(document.body).on('click', '.deleteRecord', function () {
        var recordid = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure to delete?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete.',
            reverseButtons: true,
            width: '400px',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: DELETE_DATA,
                    data: { recordid: recordid },
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message || 'Deleted successfully.'
                        });
                        // BUG-007 — also hand the message off so it survives the reload
                        sessionStorage.setItem('digilock_success_msg', response.message || 'Deleted successfully.');
                        setTimeout(function(){ location.reload(true); }, 600);
                    },
                    error: function (xhr) {
                        var response;
                        try { response = $.parseJSON(xhr.responseText); } catch (e) { response = {}; }
                        Toast.fire({
                            icon: 'error',
                            title: (response && response.message) || 'An error occurred.'
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
