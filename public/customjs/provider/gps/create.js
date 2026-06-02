
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
        $('#add_provider_name_error').text('');
    });
    $(document).on('change', 'input[name="status"]', function () {
        $('#add_status_error').text('');
    });

    $(document).on('click', '#addBtn', function () {
        $('form#addForm').submit();
    });

    $('form#addForm').on('submit', function () {
        var formData = new FormData(this);
    
        // Clear previous errors (only text)
        $('.error').text('');
    
        $('#addBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
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
                window.location.href = LISTING;
            },
    
            error: function (xhr) {
                $('#addBtn').html('Save').attr('disabled', false);
    
                var response = $.parseJSON(xhr.responseText);
    
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation error.'
                });
    
                const errors = response.data || {};
    
                Object.entries(errors).forEach(([field, messages]) => {
    
                    // Convert array fields (quantity.0 → quantity_0)
                    let errorField = field.replace(/\./g, '_');
    
                    // Show error ONLY in <small>
                    $(`#add_${errorField}_error`).text(messages[0]);
    
                });
            }
        });
    
        return false;
    });
    
    
    


});







