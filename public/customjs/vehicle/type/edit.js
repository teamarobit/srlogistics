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
    
    // set initial counter based on existing rows
    let counter = $('.vehicle-size-wrapper .vehicle-size-row, .vehicle-size-wrapper .added-vs-sec').length;

    $(document).on('click', '.add-vs', function () {
    
        counter++;
        
        let newRow = `
        <div class="card p-3 mb-3 vehicle-size-row position-relative" data-vehiclesize-id="">
            <input type="hidden" name="vehiclesize_id[${counter}]" value="">
            <a href="javascript:void(0)"
               class="text-secondary dell-vs position-absolute"
               style="top:10px; right:10px;">
                <i class="uil uil-times-circle"></i>
            </a>

            <div class="row">
                <div class="col-12 col-md-3">
                    <label>Vehicle Size <span class="text-danger">*</span></label>
                </div>

                <div class="col-12 col-md-6">
                    <input type="text"
                           class="form-control"
                           name="vehiclesize_name[${counter}]" />
    
                    <small class="error text-danger"
                           id="edit_vehiclesize_name_${counter}_error"></small>
    
                    <div class="mt-3">
                        <div class="row form-group">
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                           id="length-${counter}"
                                           class="form-control decimalonly"
                                           name="vehiclesize_length[${counter}]" />
                                    <label for="length-${counter}">Length (ft)</label>
                                </div>
                                <small class="error text-danger"
                                       id="edit_vehiclesize_length_${counter}_error"></small>
                            </div>
    
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                           id="height-${counter}"
                                           class="form-control decimalonly"
                                           name="vehiclesize_height[${counter}]" />
                                    <label for="height-${counter}">Height (ft)</label>
                                </div>
                                <small class="error text-danger"
                                       id="edit_vehiclesize_height_${counter}_error"></small>
                            </div>
    
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <input type="text"
                                           id="width-${counter}"
                                           class="form-control decimalonly"
                                           name="vehiclesize_width[${counter}]" />
                                    <label for="width-${counter}">Width (ft)</label>
                                </div>
                                <small class="error text-danger"
                                       id="edit_vehiclesize_width_${counter}_error"></small>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        
        $('.vehicle-size-wrapper').append(newRow);
    });
    
    // delete dynamically added row
    $(document).on('click', '.dell-vs', function () {
        $(this).closest('.vehicle-size-row').remove();
    });

    
    
    
    //==========================================================================
    
    
    $(document).on('click','#editBtn',function(){
        $('form#editForm').submit();
    });
    
    $('form#editForm').on('submit', function(){
        var formData = new FormData(this);
        // Ensure hidden field is included
        formData.append('vehicletypeid', $('#edit_vehicletypeid_input').val());
    
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
                window.location.href = VEHILE_TYPES;
            },
            error: function (xhr) {
                    $('#editBtn').html('Save').prop('disabled', false);
        
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
                    }).then((resp) => {
                        if(response.should_reload){
                            location.reload(true);
                        }
                    });

                    const errors = response.data || {};

                    Object.entries(errors).forEach(([field, messages]) => {
                        const msg = messages[0];
        
                        const $radio = $(`[name="${field}"]`);
                        if ($radio.length && ['radio', 'checkbox'].includes($radio.attr('type'))) {
                            $radio.addClass('is-invalid');
                            $(`#edit_${field}_error`).text(msg);
                            return;
                        }
        
                        const $input = $(`[name="${field}"]`);
                        if ($input.length) {
                            $input.addClass('is-invalid');
                            $input.after(`<div class="invalid-feedback d-block">${msg}</div>`);
                        } else {
                            $(`#edit_${field}_error`).text(msg);
                        }
                    });
                    
            }

            
        });
    
        return false;
    });

    
    
    
    
    
    


});





