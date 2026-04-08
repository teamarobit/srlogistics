
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
                window.location.href = SKILLSETS;
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
                    const nameAttr = field.replace(/\.(\d+)/g, '[$1]'); // quantity.0 → quantity[0]
                    const $input = $(`[name="${nameAttr}"]`);
                    
                    if ($input.length) {

                        // If radio or checkbox group
                        if ($input.attr('type') === 'radio' || $input.attr('type') === 'checkbox') {
                    
                            // Add invalid class to all radios in the group
                            $input.addClass('is-invalid');
                    
                            // Show only ONE message in your custom span
                            $(`#add_${field}_error`).text(messages[0]);
                    
                        } else {
                            // Normal inputs
                            $input.addClass('is-invalid');
                            $input.after(`<div class="invalid-feedback d-block">${messages[0]}</div>`);
                        }
                    
                    } else {
                        // Fallback
                        $(`#add_${field}_error`).text(messages[0]);
                    }

                });
            }
        });
    
        return false;
    });


    
    


});







