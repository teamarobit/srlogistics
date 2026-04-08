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
        formData.append('designationid', $('#edit_designationid_input').val());
    
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
                window.location.href = DESIGNATIONS;
            },
            error: function (xhr) {

                $('#editBtn').html('Save').attr('disabled', false);
            
                let response = xhr.responseJSON || {};
                let errors   = response.errors || response.data || {};
            
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please fix the errors below.'
                });
            
                // Clear old errors
                $('.error').text('');
                $('.is-invalid').removeClass('is-invalid');
                $('.select2-container').removeClass('is-invalid');
            
                $.each(errors, function (field, messages) {
            
                    let msg = messages[0];
            
                    // Handle array fields: items.0.name → items[0][name]
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
            
                    let $input = $(`[name="${nameAttr}"]`);
            
                    // RADIO / CHECKBOX
                    if ($input.length && ($input.attr('type') === 'radio' || $input.attr('type') === 'checkbox')) {
            
                        $input.addClass('is-invalid');
                        $(`#edit_${field}_error`).text(msg);
                        return;
                    }
            
                    // SELECT2
                    if ($input.length && $input.hasClass('select2')) {
            
                        $input.next('.select2-container').addClass('is-invalid');
                        $(`#edit_${field}_error`).text(msg);
                        return;
                    }
            
                    // NORMAL INPUT
                    if ($input.length) {
                        $input.addClass('is-invalid');
                        $(`#edit_${field}_error`).text(msg);
                        return;
                    }
            
                    // FINAL FALLBACK
                    $(`#edit_${field}_error`).text(msg);
                });
            }

        });
    
        return false;
    });

    
    
    
    
    


});





