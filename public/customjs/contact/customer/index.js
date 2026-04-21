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
    
    
    $('#search_city').data('select2').$container.find('.select2-selection__placeholder').text('Filter by City');
    $('#search_size').data('select2').$container.find('.select2-selection__placeholder').text('Filter by Size');
    
    
    
    
    $('#search_name , #search_city , #search_size').on('change blur', function () { 
        $('#searchform').submit();
    });
    
    
    
    
    $(document).on('change', '#selectAll', function () {
        $('.rowCheckbox').prop('checked', this.checked);
    });
    
    $(document).on('change', '.rowCheckbox', function () {
        if ($('.rowCheckbox:checked').length == $('.rowCheckbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });
    
    $('#confirmDelete').click(function () {

        let type = $('input[name="deleteType"]:checked').val();
    
        if (type === 'selected') {
    
            let ids = [];
    
            $('.rowCheckbox:checked').each(function () {
                ids.push($(this).val());
            });
    
            if (ids.length === 0) {
                Toast.fire({ icon: "error", title: 'Please select at least one row.' });
                
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
    
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
    
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
    
                    } else {
    
                        Toast.fire({
                            icon: "error",
                            title: response.message
                        });
    
                    }
                },
                error: function (xhr) {

                    let message = "Something went wrong.";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } 
                    else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors)
                                        .flat()
                                        .join(', ');
                    }

                    Toast.fire({
                        icon: "error",
                        title: message
                    });
                }
            });
    
        } else if (type === 'all') {
            
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete all records.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
            
                if (result.isConfirmed) {
            
                    let formData = $('#searchform').serializeArray();
                    formData.push({ name: 'cotype', value: CO_TYPE });
                    formData.push({ name: '_token', value: $('meta[name="csrf-token"]').attr('content') });
            
                    $.ajax({
                        url: DELETE_ALL,
                        type: 'POST',
                        data: formData,
                        success: function (response) {
            
                            if (response.success) {
            
                                Toast.fire({
                                    icon: "success",
                                    title: response.message
                                });
            
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
            
                            } else {
            
                                Toast.fire({
                                    icon: "error",
                                    title: response.message
                                });
            
                            }
                        }
                    });
            
                }
            
            });

    
        }
    
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*$(document.body).on('click', '.deleteRecord', function () {
        var recordId = $(this).data('id');
        var actmodelid = $(this).data('actmodelid'); 
    
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
                var formData = new FormData();
                formData.append('id', recordId);
                formData.append('actmodelid', actmodelid);
    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: DELETE_CONTACT, // Make sure this is defined
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        location.reload(true); // or remove the row from the table dynamically
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
    });*/

    
    
    
    
    
});

