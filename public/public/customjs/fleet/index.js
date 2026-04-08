$(document).ready(function(){
    
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
    
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    
    
    
    function loadFleetData(url = null){

        let status = $('#status').val();
        let formData = $('#searchform').serialize();
        let requestUrl = url ? url : $('#searchform').attr('action');

        let tableId = status ? '#fleetTableBody_'+status : '#fleetTableBody_all';

        $.ajax({
            url: requestUrl,
            type: "GET",
            data: formData,
            beforeSend:function(){
                $(tableId).html('<tr><td colspan="8" class="text-center">Loading...</td></tr>');
            },
            success: function(response){

                $(tableId).html(response);

            }
        });

    }


    // TAB CLICK
    $('.fleetTab').on('click', function(){

        let status = $(this).data('status');

        $('#status').val(status);

        loadFleetData();

    });


    // FILTER CHANGE
    $('#v_vehiclegroup_id, #v_ownership_id').on('change', function(){
        loadFleetData();
    });
    
    // FILTER 
    $('#v_driver, #v_managed_by, #v_vehicle_no').on('keyup', function(){
        loadFleetData();
    });


    // AJAX PAGINATION
    $(document).on('click', '.pagination a', function(e){

        e.preventDefault();

        let url = $(this).attr('href');

        loadFleetData(url);

    });
    
    
    
    
    $(document).on('click','.exportData',function(){

        let type = $(this).data('type');
    
        let formData = $('#searchform').serialize();
    
        let url = $('#searchform').attr('action') + '?export=' + type + '&' + formData;
    
        window.location.href = url;
    
    });
    
    
    
    
    
    
    // IMPORT (23-03-2026)
    /*$(document).on('click', '.bulk-type', function () {

        let type = $(this).data('type');
        let filePath = '';
    
        if (type === 'gps') {
            filePath = GPS_EXCEL;
        } 
        else if (type === 'fastag') {
            filePath = FASTAG_EXCEL;
        } 
        else if (type === 'battery') {
            filePath = BATTERY_EXCEL;
        }
        else if (type === 'tyre') {
            filePath = TYRE_EXCEL;
        }
        
        $('#import_type').val(type);
    
        $('#sampleFileLink').attr('href', filePath);
    });*/
    
    
    
    $(document).on('change', '.bulk-type', function () {
        var selectedType = $(this).val();
        console.log(selectedType);
        
        $('#upload_file_div').show();
        
        var formattedType = selectedType.charAt(0).toUpperCase() + selectedType.slice(1);
        $('.fileTypeName').text(formattedType);
        
        let filePath = '';
        if (selectedType === 'gps') {
            filePath = GPS_EXCEL;
        } 
        else if (selectedType === 'fastag') {
            filePath = FASTAG_EXCEL;
        } 
        else if (selectedType === 'battery') {
            filePath = BATTERY_EXCEL;
        }
        else if (selectedType === 'tyre') {
            filePath = TYRE_EXCEL;
        }
        $('#sampleFileLink').attr('href', filePath);
    
    });
    
    
    
    $('#file_upload').on('change', function () {
        let file = this.files[0];
    
        if (file) {
            $('#preview').show();
            $('#fileName').text(file.name);
        }
    });
    
    
    
    
    
    
    
    $(document).on('click', '#bulkUploadBtn', function () {
        $('form#bulkUploadForm').submit();
    });
    
    $('form#bulkUploadForm').on('submit', function () {
        var formData = new FormData(this);
    
        $('#bulkUploadBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            data: formData,
            url: $(this).attr('action'),
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (response) { console.log(response);
                Toast.fire({
                    icon: 'success',
                    title: response.message || 'Saved successfully!'
                });
                $('#bulkUploadBtn').html('Save').attr('disabled', false);
                window.location.reload();
            },
    
            error: function (xhr) {
                $('#bulkUploadBtn').html('Save').attr('disabled', false);
            
                var response = $.parseJSON(xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation error.'
                });
            
                const errors = response.data || {};
                Object.entries(errors).forEach(([field, messages]) => {
            
                    const nameAttr = field.replace(/\.(\d+)/g, '[$1]'); // quantity.0 → quantity[0]
                    const $input = $(`[name="${nameAttr}"]`);
            
                    // Clear any previous small.error for this field first, if you prefer:
                    // $(`#add_${field}_error`).text('');
            
                    if ($input.length) {
            
                        // If radio or checkbox group
                        if ($input.attr('type') === 'radio' || $input.attr('type') === 'checkbox') {
            
                            // Put the message into your existing small.error span
                            $(`#add_${field}_error`).text(messages[0]);
            
                        } else {
                            
                            // Try to find existing small.error span
                            let $small = $(`#add_${field}_error`);
            
                            if ($small.length) {
                                // set text
                                $small.text(messages[0]);
                            } else {
                                // fallback: create the small.error right after the input
                                $input.after(
                                    `<small class="error text-danger" id="add_${field}_error">${messages[0]}</small>`
                                );
                            }
                        }
            
                    } else {
                        // Fallback if input not found
                        $(`#add_${field}_error`).text(messages[0]);
                    }
            
                });
            }
        });
    
        return false;
    });
    
    
    
    
    
    
    
    
    
});

