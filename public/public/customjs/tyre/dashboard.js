const baseUrl = window.location.origin + window.location.pathname;
const storageKey = `activeNav_${baseUrl}`;

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
    
    $('.expiry_date').daterangepicker({
        singleDatePicker: true,   
        timePicker: false,        
        locale: {
          format: 'MM/DD/YYYY',   
        }
    });
    
    
    $('.search_input').on('change blur', function () { 
        $('#searchform').submit();
    });
    
    $(document.body).on('click', '.mark_as_discard', function () {
        let url = $(this).data('url');
        $('#discardTyreForm').attr('action', url);
        $('#discardTyreModal').modal('show');
    });
    
    $(document).on('click', '.submitBtn', function () {
        $('#discardTyreForm').submit();
    });
    
    $('form#discardTyreForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        const actionUrl = $(this).attr('action');
        
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Are you sure to discard?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Discard It',
            cancelButtonText: 'Do not discard',
            reverseButtons: true,
            //width: '400px',
            customClass: {
                confirmButton: 'btn btn-danger btn-lg me-2', 
                cancelButton: 'btn btn-primary btn-lg me-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $('.submitBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        
                $('.error').html('');
                $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : actionUrl,
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        Toast.fire({
                          icon: 'success',
                          title: response.message,
                          didClose: function(){
                            location.reload(true);
                          }
                        });
                        
                        $('#discardTyreModal').modal('hide');
                        $('.submitBtn').html('Save');
                    },
                    error       : function(data){
                        var response = data.responseJSON;
                        
                        Toast.fire({
                          icon: 'error',
                          title: response.message
                        });
                        
                        $.each(response.data, function(index, value){
                            $('#'+index+'_error').text(value[0]);
                        });
                        
                        $('.submitBtn').html('Save').attr('disabled', false);
                    }
        
                });
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'No action taken.'
                });
            }
        });
        
        return false;
    });
    
    
    const savedNav = localStorage.getItem(storageKey);
    
    let targetEl;
    $(document).on('click', '.nav_click', function(e){
        e.preventDefault();
    
        const navTarget = $(this).data('bs-target');
        
        localStorage.setItem(storageKey, navTarget);
    });

    if(savedNav){
        targetEl = document.querySelector(`.nav_click[data-bs-target="${savedNav}"]`);
    } else {
        targetEl = document.querySelector('.nav_click');
    }

    if(targetEl){
        const tab = new bootstrap.Tab(targetEl);
        tab.show();
    }
    
});


