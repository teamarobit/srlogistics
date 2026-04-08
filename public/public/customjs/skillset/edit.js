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
    
    
    
    
    $(document).on('click','#editBtn',function(){
        $('form#editForm').submit();
    });
    
    $('form#editForm').on('submit', function(){
        var formData = new FormData(this);
        // Ensure hidden field is included
        formData.append('skillsetid', $('#edit_skillsetid_input').val());
    
        $('.error').html('');
        $('#editBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                Toast.fire({
                    icon: 'success',
                    title: response.message || 'Saved successfully!'
                });
                $('#editBtn').html('Save').attr('disabled', false);
                window.location.href = SKILLSETS;
            },
            error: function(xhr){
                $('#editBtn').html('Save').attr('disabled', false);
                var response = $.parseJSON(xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation error.'
                });
    
                const errors = response.data || {};
                Object.entries(errors).forEach(([field, messages]) => {
                    const $input = $(`[name="${field}"]`);
                    if ($input.length) {
                        $input.addClass('is-invalid');
                        $(`#edit_${field}_error`).text(messages[0]);
                    }
                });
            }
        });
    
        return false;
    });

    
    
    
    
    


});





