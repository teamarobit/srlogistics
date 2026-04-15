var LISTING = "{{ route('vehiclemanagement.index') }}";
var VEHICLETYPE_SIZES = "{{ route('vehicletype.sizes', ':id') }}";

var EDIT_VEHICLETYPE_ID = "{{ $record->vehicletype_id }}";
var EDIT_VEHICLESIZE_ID = "{{ $record->vehicletypesize_id }}";

var FETCH_VEHICLE_INFO = "{{ route('vehiclemanagement.fetchInfo') }}";

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

    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let vc_no = $('#vc_no').val().trim();

    if(vc_no !== ''){
        fetchVehicleInfo(vc_no);
    }
    
    function fetchVehicleInfo(vc_no){

        $.ajax({
            url: FETCH_VEHICLE_INFO,
            type: "POST",
            data: { vc_no: vc_no },
    
            beforeSend:function(){
                $('#fetchData').prop('disabled', true);
                $('.fetched-data').html('<p class="text-center p-3">Fetching vehicle data...</p>');
            },
    
            success:function(response){ 
                console.log(response);
                
                $('.fetched-data').html(response);
            },
    
            error:function(xhr){
                console.log(xhr.responseText);
                
                $('.fetched-data').html('<p class="text-danger text-center p-3">Vehicle not found</p>');
            },
    
            complete:function(){
                $('#fetchData').prop('disabled', false);
            }
        });
    }
    
    
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
    
        fetchVehicleInfo(vc_no);
    
    });
    
    
    
    $(document).on('click', '.vehicleTypeId', function(){
        let vehicleTypeId = $(this).val();
    
        loadVehicleSizes(vehicleTypeId);
    });
    
    if(typeof EDIT_VEHICLETYPE_ID !== "undefined" && EDIT_VEHICLETYPE_ID !== ""){
        loadVehicleSizes(EDIT_VEHICLETYPE_ID, EDIT_VEHICLESIZE_ID);
    }
    
    
    function loadVehicleSizes(vehicleTypeId, selectedSize = null){

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
    
                        let selected = selectedSize == size.id ? 'selected' : '';
    
                        options += `<option value="${size.id}" ${selected}>
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
    
    }
    
    
    
    //==========================================================================
    
    
    $(document).on('click','#editBtn',function(){
        $('form#editForm').submit();
    });
    
    $('form#editForm').on('submit', function(){
        var formData = new FormData(this);
        // Ensure hidden field is included
        formData.append('id', $('#edit_id_input').val());
    
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
                window.location.href = LISTING;
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
                });
            
                const errors = response.data || response.errors || {};
            
                // clear previous errors
                $('small.error').text('');
            
                Object.entries(errors).forEach(([field, messages]) => {
            
                    let msg = messages[0];
            
                    // show error inside your small tag
                    $('#edit_' + field + '_error').text(msg);
            
                });
            
            }

            
        });
    
        return false;
    });

    
    
    
    
    
    
    
    


});





