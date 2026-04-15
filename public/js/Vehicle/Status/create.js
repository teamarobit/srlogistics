var VEHILE_TYPES = "{{ route('vehiclestatus.index') }}";\n\n
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
                window.location.href = VEHILE_STATUS;
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
                         Special cases
                        ----------------------------- */
        
                        if (field === 'tollstation_id' || field.startsWith('tollstation_id.')) {
                            $('.toll-wrapper select').first().addClass('is-invalid');
                            $('.tollstation-error').text(msg);
                            return;
                        }
        
                        if (field === 'rto_id' || field.startsWith('rto_id.')) {
                            $('.rto-wrapper select').first().addClass('is-invalid');
                            $('.rto-error').text(msg);
                            return;
                        }
        
                        /* -----------------------------
                         Dynamic ARRAY fields (vehiclesize_*)
                        ----------------------------- */
        
                        if (field.includes('.')) {
                            const errorId = field.replace('.', '_') + '_error';
                            $('#' + errorId).text(msg);
        
                            const nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                            $(`[name="${nameAttr}"]`).addClass('is-invalid');
                            return;
                        }
        
                        /* -----------------------------
                         Radio / Checkbox
                        ----------------------------- */
        
                        const $radio = $(`[name="${field}"]`);
                        if ($radio.length && ['radio', 'checkbox'].includes($radio.attr('type'))) {
                            $radio.addClass('is-invalid');
                            $(`#add_${field}_error`).text(msg);
                            return;
                        }
        
                        /* -----------------------------
                         Normal inputs / selects
                        ----------------------------- */
        
                        const $input = $(`[name="${field}"]`);
                        if ($input.length) {
                            $input.addClass('is-invalid');
                            $input.after(`<div class="invalid-feedback d-block">${msg}</div>`);
                        } else {
                            $(`#add_${field}_error`).text(msg);
                        }
                    });
                    
            }

        });
    
        return false;
    });


    
    


});









