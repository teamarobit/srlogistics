
$(document).ready(function() {
    
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
    
    
    
    
    $(document).on('click', '#addBtn', function () {
        $('form#addForm').submit();
    });

    $('form#addForm').on('submit', function () {
        var formData = new FormData(this);
    
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    
        $('#addBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            data: formData,
            url: $(this).attr('action'),
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (response) {
                Toast.fire({
                    icon: 'success',
                    title: response.message || 'Saved successfully!'
                });
                $('#addBtn').html('Save').attr('disabled', false);
                window.location.href = DESIGNATIONS;
            },
            
            error: function (xhr) {

                $('#addBtn').html('Save').attr('disabled', false);
            
                let response = xhr.responseJSON || {};
                let errors   = response.errors || response.data || {};
            
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please fix the errors below.'
                });
            
                // Clear old errors
                $('.error').text('');

                $.each(errors, function (field, messages) {
                    $(`#add_${field}_error`).text(messages[0]);
                });
            }

        });
    
        return false;
    });


    
    


});







