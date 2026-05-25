
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
    
    
    
    
    //==========================================================================
    
    
    $(document).on('click', '#addBtn', function () {
        $('form#addForm').submit();
    });

    $('form#addForm').on('submit', function () {
        var formData = new FormData(this);

        // Clear previous errors
        $('.error.text-danger').text('');

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

                setTimeout(() => {
                    window.location.href = LISTING;
                }, 2000);
            },

            error: function (xhr) {
                    $('#addBtn').html('Save').prop('disabled', false);

                    let response = {};
                    try {
                        response = JSON.parse(xhr.responseText);
                    } catch (e) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                        return;
                    }

                    Toast.fire({
                        icon: 'error',
                        title: response.message || 'Please check validation errors.'
                    });

                    const errors = response.data || {};

                    Object.entries(errors).forEach(([field, messages]) => {
                        const msg = messages[0];

                        /* -----------------------------
                         Dynamic ARRAY fields
                        ----------------------------- */

                        if (field.includes('.')) {
                            const errorId = field.replace('.', '_') + '_error';
                            $('#' + errorId).text(msg);
                            return;
                        }

                        /* -----------------------------
                         All fields — show error in span below input
                        ----------------------------- */

                        $(`#add_${field}_error`).text(msg);
                    });

            }

        });

        return false;
    });

    


});









