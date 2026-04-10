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

$(document).ready(function(){
    
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    
    $('#search_name, #search_department_id, #search_designation_id').on('change blur', function () { 
        $('#searchform').submit();
    });
    
    
    // =========================================================================
    function loadDependentDropdown({
        parentSelector,
        childSelector,
        urlTemplate,
        placeholder = 'Select Option',
        valueKey = 'id',
        textKey = 'name'
    }) {
        $(document).on('change', parentSelector, function () {
            let parentId = $(this).val();
    
            let $child = $(childSelector);
            $child.html(`<option value="">${placeholder}</option>`);
    
            if (!parentId) return;
    
            $.ajax({
                url: urlTemplate.replace('__ID__', parentId),
                type: 'GET',
                success: function (response) {
                    $.each(response, function (_, item) {
                        $child.append(
                            `<option value="${item[valueKey]}">${item[textKey]}</option>`
                        );
                    });
                }
            });
        });
    }
    
    loadDependentDropdown({
        parentSelector: '#search_department_id',
        childSelector: '#search_designation_id',
        urlTemplate: DESIGNATION_URL,
        placeholder: 'Select Designation'
    });
    
    
    
    
    $(document.body).on('click', '.deleteRecord', function () {
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
                    url: DELETE_JOBRANK, // Make sure this is defined
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
    });

    
    
    
    
    
});

