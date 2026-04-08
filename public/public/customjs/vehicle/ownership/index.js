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
    
    
    $('#search_name, #search_status').on('change blur', function () { 
        $('#searchform').submit();
    });
    
    
    $(document.body).on('click', '.deleteBtn', function () {
        //var rowid = $(this).data('id');
        
        let url = $(this).data('url');
    
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Are you sure to delete?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete.',
            reverseButtons: true,
            //width: '400px',
            customClass: {
                confirmButton: 'btn btn-danger btn-lg me-2',   // adds right margin
                cancelButton: 'btn btn-secondary btn-lg me-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // var formData = new FormData();
                // formData.append('id', rowid);
    
                $.ajax({
                    url: url,
                    method: 'GET',
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


