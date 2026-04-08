
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
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#fetchData').click(function(){ 

        let vc_no = $('#vc_no').val().trim();
    
        if(vc_no == ''){
            Toast.fire({
                icon: 'error',
                title: 'Please enter vehicle number!'
            });
            return;
        }
    
        $.ajax({
            url: FETCH_VEHICLE_INFO,
            type: "POST",
            data: {
                vc_no: vc_no
            },
            beforeSend:function(){
                $('#fetchData').prop('disabled', true);
                $('.fetched-data').html('<p class="text-center p-3">Fetching vehicle data...</p>');
            },
            success:function(response){ 
                //console.log(response);
                
                $('.fetched-data').html(response);
            },
            error:function(){
                $('.fetched-data').html('<p class="text-danger text-center p-3">Vehicle not found</p>');
            },
            complete:function(){
                $('#fetchData').prop('disabled', false);
            }
        });
    
    });
    
    
    $(document).on('click', '.vehicleTypeId', function(){

        let vehicleTypeId = $(this).val();
        let url = VEHICLETYPE_SIZES.replace(':id', vehicleTypeId);
    
        $.ajax({
            url: url,
            type: "GET",
    
            beforeSend:function(){
                $('#vehicle_size').html('<option>Loading...</option>');
            },
    
            success:function(response){
    
                let options = '<option value="">Choose</option>';
    
                if(response.success && response.sizes.length > 0){
    
                    response.sizes.forEach(function(size){
    
                        options += `<option value="${size.id}">
                            ${size.name} - ${size.height} * ${size.width} * ${size.length}
                        </option>`;
    
                    });
    
                }else{
    
                    options += `<option value="">No sizes found</option>`;
    
                }
    
                $('#vehicle_size').html(options);
    
            },
    
            error:function(){
                $('#vehicle_size').html('<option value="">Error loading sizes</option>');
            }
    
        });
    
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
                window.location.href = LISTING;
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
            
                const errors = response.data || response.errors || {};
            
                // clear previous errors
                $('small.error').text('');
            
                Object.entries(errors).forEach(([field, messages]) => {
            
                    let msg = messages[0];
            
                    // show error inside your small tag
                    $('#add_' + field + '_error').text(msg);
            
                });
            
            }

        });
    
        return false;
    });


    
    


});









