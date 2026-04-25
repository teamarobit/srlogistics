
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
    
    function reIndexVehicleSizes() {

        $('.vehicle-size-wrapper .vehicle-size-row').each(function (i) {
    
            $(this).attr('data-index', i);
    
            // Fix error IDs
            $(this).find('small.error').each(function () {
                let base = $(this).attr('id').split('_').slice(0, -2).join('_');
                $(this).attr('id', base + '_' + i + '_error');
            });
    
            // First row cannot be deleted
            if (i === 0) {
                $(this).find('.dell-vs').remove();
            }
        });
    }

    // ADD ROW
    $(document).on('click', '.add-vs', function () {
    
        let index = $('.vehicle-size-wrapper .vehicle-size-row').length;
    
        let newRow = `
        <div class="card p-3 mt-3 vehicle-size-row" data-index="${index}">
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
                    <input type="text" name="vehiclesize_name[]" class="form-control">
                    <small class="error text-danger" id="vehiclesize_name_${index}_error"></small>
    
                    <div class="mt-3">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" name="vehiclesize_length[]" class="form-control decimalonly">
                                    <label>Length (ft)</label>
                                </div>
                                <small class="error text-danger" id="vehiclesize_length_${index}_error"></small>
                            </div>
    
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" name="vehiclesize_height[]" class="form-control decimalonly">
                                    <label>Height (ft)</label>
                                </div>
                                <small class="error text-danger" id="vehiclesize_height_${index}_error"></small>
                            </div>
    
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" name="vehiclesize_width[]" class="form-control decimalonly">
                                    <label>Width (ft)</label>
                                </div>
                                <small class="error text-danger" id="vehiclesize_width_${index}_error"></small>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    
        $('.vehicle-size-wrapper').append(newRow);
    
        // re-bind decimal logic if needed
        $('.decimalonly').trigger('input');
    });
    
    // DELETE ROW
    $(document).on('click', '.dell-vs', function () {
        $(this).closest('.vehicle-size-row').remove();
        reIndexVehicleSizes();
    });

    
    
    //==========================================================================
    
    
    $(document).on('click', '#addBtn', function () {
        $('form#addForm').submit();
    });

    $('form#addForm').on('submit', function () {

        var formData = new FormData(this);
    
        // Clear previous errors
        $('.error').text('');
    
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
    
                window.location.href = VEHILE_TYPES;
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
    
                    /* Dynamic array fields */
                    if (field.includes('.')) {
    
                        const errorId = field.replace('.', '_') + '_error';
                        $('#' + errorId).text(msg);
    
                        return;
                    }
    
                    /* Normal fields / radio / select */
                    $('#add_' + field + '_error').text(msg);
    
                });
    
            }
    
        });
    
        return false;
    });


    
    


});









