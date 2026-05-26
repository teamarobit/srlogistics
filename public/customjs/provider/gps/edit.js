$(document).ready(function() {

    var LISTING = $('#page-config').data('listing');

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
    
    
    
    
    // Clear inline validation error as soon as the user edits the field.
    $(document).on('input keyup', 'input[name="provider_name"]', function () {
        $('#edit_provider_name_error').text('');
    });
    $(document).on('change', 'input[name="status"]', function () {
        $('#edit_status_error').text('');
    });

    $(document).on('click', '#editBtn', function () {
        $('form#editForm').submit();
    });

    $('form#editForm').on('submit', function () {
        var formData = new FormData(this);
    
        // Ensure hidden field is included
        formData.append('recordid', $('#edit_id_input').val());
    
        // Clear previous errors
        $('.error').text('');
    
        $('#editBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (response) {
                Toast.fire({
                    icon: 'success',
                    title: response.message || 'Saved successfully!'
                });
    
                $('#editBtn').html('Save').attr('disabled', false);
                window.location.href = LISTING;
            },
    
            error: function (xhr) {
                $('#editBtn').html('Save').attr('disabled', false);
    
                var response = $.parseJSON(xhr.responseText);
    
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation error.'
                });
    
                const errors = response.data || {};
    
                Object.entries(errors).forEach(([field, messages]) => {
    
                    // handle array fields if any (field.0 → field_0)
                    let errorField = field.replace(/\./g, '_');
    
                    // ONLY show inside <small>
                    $(`#edit_${errorField}_error`).text(messages[0]);
    
                });
            }
        });
    
        return false;
    });

    
    
    
    
    


});





