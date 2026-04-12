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


Dropzone.autoDiscover = false;

const MAX_ATTACHMENTS = 2;
let attachmentIndex = 0;
let dzInstance = null;
let editDzInstance = null;

function initDropzone() {
    const myDropzone = document.getElementById(`myDropzone`);
    if (!myDropzone) return;

    // Prevent double init
    if (myDropzone.dropzone) return;

    dzInstance = new Dropzone(myDropzone, {
        url: '/upload/images',
        paramName: "files",
        maxFiles: MAX_ATTACHMENTS,
        maxFilesize: 2,
        acceptedFiles: ".webp,.jpg,.jpeg,.png,.pdf",
        addRemoveLinks: true,
        parallelUploads: MAX_ATTACHMENTS,
        autoProcessQueue: false,
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') }
    });
    
    // Event: file exceeds max
    dzInstance.on("maxfilesexceeded", function(file) {
        dzInstance.removeFile(file); // Remove the extra file
        Toast.fire({
                      icon: 'error',
                      title: "Maximum 2 attachments allowed!"
                    });
    });
}

function editInitDropzone() {
    const myDropzone = document.getElementById(`edit_myDropzone`);
    if (!myDropzone) return;

    // Prevent double init
    if (myDropzone.dropzone) return;

    editDzInstance = new Dropzone(myDropzone, {
        url: '/upload/images',
        paramName: "files",
        maxFiles: MAX_ATTACHMENTS,
        maxFilesize: 2,
        acceptedFiles: ".webp,.jpg,.jpeg,.png,.pdf",
        addRemoveLinks: true,
        parallelUploads: MAX_ATTACHMENTS,
        autoProcessQueue: false,
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') }
    });
    
    // Event: file exceeds max
    editDzInstance.on("maxfilesexceeded", function(file) {
        editDzInstance.removeFile(file); // Remove the extra file
        Toast.fire({
                      icon: 'error',
                      title: "Maximum 2 attachments allowed!"
                    });
    });
}

function setDateRangePicker(selector, date) {
    
    let picker = $(selector).data('daterangepicker');

    if (!date) {
        $(selector).val('');
        return;
    }

    let formattedDate = moment(date, 'DD/MM/YYYY');

    picker.setStartDate(formattedDate);
    picker.setEndDate(formattedDate);

    $(selector).val(formattedDate.format('DD/MM/YYYY'));
}




$(document).ready(function(){
    
    
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    
    
    $('.datetime').daterangepicker({
        singleDatePicker: true,   
        timePicker: true,         
        startDate: moment(),      
        locale: {
          format: 'MM/DD/YYYY hh:mm A' 
        }
    });
    
    
    const baseUrl = window.location.origin + window.location.pathname;
    const storageKey = `activeNav_${baseUrl}`;
    
    initDropzone();
    editInitDropzone();
      
    
    
    $(document).on('click', '.edit-driver-btn', function () {

        let vehicleId = $(this).data('id');
        
        let url = DRIVER_DATA.replace(':id', vehicleId);
    
        $.ajax({
            url: url,
            type: 'GET',
            success: function (res) {
                
                if (res.success) {

                    let vehicle = res.data.vehicle;
                    let drivers = res.data.drivers;
    
                    console.log(vehicle); 
                    
                    // Driver Name
                    let driverName = vehicle.driver_allocation?.contact?.contact_name ?? 'Not Assigned';
                    
                    // Vehicle Number
                    let vehicleNo = vehicle.vehicle_no ?? '-';
                    
                    // current_driver_id
                    let currentDriverId = res.data.current_driver_id ?? '';
                    
                    $('#modal_current_driver_id').val(currentDriverId);
                    

                    // Populate dropdown
                    let options = '<option value="">Select Driver</option>';
                    
                    drivers.forEach(function (driver) {
                        options += `<option value="${driver.id}">
                            ${driver.contact_name} - ${driver.phone ?? ''}
                        </option>`;
                    });
                    
                    $('#driver_select').html(options);

    
                    // Set values in modal
                    $('#modal_driver_name').text(driverName);
                    $('#modal_vehicle_no').text(vehicleNo);
                    $('#modal_vehicle_id').val(vehicle.id);
                }
            

    
            }
        });
    
    });
    
    
    
    
    //--------------------------------------------------------------------------
    
    $(document).on('click', '#modifyDriverBtn', function () {
        $('#modifyDriverForm').submit();
    });
    
    $('#modifyDriverForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
        //$('.is-invalid').removeClass('is-invalid');
    
        $('#modifyDriverBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#modifyDriverBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#modifyDriverBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Add invalid class
                    //$input.addClass('is-invalid');
    
                    // Handle Select2
                    if ($input.hasClass('select2')) {
                        // $input.next('.select2-container').find('.select2-selection')
                        //     .addClass('is-invalid');
                    }
    
                    // Show error in <small>
                    let errorId = `#add_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    //--------------------------------------------------------------------------
    
    // Add/Edit GPS Start ------------------------------------------------------
    
    // Auto calculate Renew Date using plan start date and GPS plan
    $(document).on('input change', '#gps_plan_start_date, #gps_plan_validity', function () {

        let startDate = $('#gps_plan_start_date').val();
        let validity = parseInt($('#gps_plan_validity').val());
    
        if (startDate && validity && validity > 0) {
    
            let parts = startDate.split('-'); // YYYY-MM-DD
            let year = parseInt(parts[0]);
            let month = parseInt(parts[1]) - 1; // JS month (0-based)
            let day = parseInt(parts[2]);
    
            let date = new Date(year, month, day);
    
            // Step 1: Add months
            let newMonth = month + validity;
            let newDate = new Date(year, newMonth, day);
    
            // Fix overflow (e.g., Jan 31 → Feb end)
            if (newDate.getDate() !== day) {
                newDate.setDate(0);
            }
    
            // Step 2: Add 1 day
            newDate.setDate(newDate.getDate() + 1);
    
            // Format YYYY-MM-DD
            let renewDate = newDate.getFullYear() + '-' +
                String(newDate.getMonth() + 1).padStart(2, '0') + '-' +
                String(newDate.getDate()).padStart(2, '0');
    
            $('#gps_plan_renew_date').val(renewDate);
    
        } else {
            $('#gps_plan_renew_date').val('');
        }
    });
    
    
    
    $(document).on('input change', '#edit_gps_plan_start_date, #edit_gps_plan_validity', function () {

        let startDate = $('#edit_gps_plan_start_date').val();
        let validity = parseInt($('#edit_gps_plan_validity').val());
        
        if (startDate && validity && validity > 0) {
    
            let parts = startDate.split('-'); // YYYY-MM-DD
            let year = parseInt(parts[0]);
            let month = parseInt(parts[1]) - 1; // JS month (0-based)
            let day = parseInt(parts[2]);
    
            let date = new Date(year, month, day);
    
            // Step 1: Add months
            let newMonth = month + validity;
            let newDate = new Date(year, newMonth, day);
    
            // Fix overflow (e.g., Jan 31 → Feb end)
            if (newDate.getDate() !== day) {
                newDate.setDate(0);
            }
    
            // Step 2: Add 1 day
            newDate.setDate(newDate.getDate() + 1);
    
            // Format YYYY-MM-DD
            let renewDate = newDate.getFullYear() + '-' +
                String(newDate.getMonth() + 1).padStart(2, '0') + '-' +
                String(newDate.getDate()).padStart(2, '0');
    
            $('#edit_gps_plan_renew_date').val(renewDate);
    
        } else {
            $('#edit_gps_plan_renew_date').val('');
        }
        
    });
    
    

    
    $(document).on('click', '#addGPSBtn', function () {
        $('#addGPSForm').submit();
    });
    
    $('#addGPSForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
        //$('.is-invalid').removeClass('is-invalid');
    
        $('#addGPSBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#addGPSBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#addGPSBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Add invalid class
                    //$input.addClass('is-invalid');
    
                    // Handle Select2
                    // if ($input.hasClass('select2')) {
                    //     $input.next('.select2-container').find('.select2-selection')
                    //         .addClass('is-invalid');
                    // }
    
                    // Show error in <small>
                    let errorId = `#add_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    
    $(document.body).on('click', '.editGPSClass', function () {

        let recordId = $(this).data('id');
    
        $.ajax({
            url: EDIT_GPS.replace(':id', recordId),
            method: 'GET',
            dataType: 'json',
    
            success: function (response) { console.log(response);
                if (response.success) {
    
                    $('#edit_id_input').val(response.data.id);
                    $('#edit_gps_provider_id').val(response.data.gpsprovider_id).trigger('change');
                    $('#edit_gps_type').val(response.data.gps_type).trigger('change');
                    $('#edit_device_issue_date').val(response.data.device_issue_date);
                    $('#edit_device_warranty').val(response.data.device_warranty); 
                    $('#edit_device_remaining_warranty').val(response.data.device_remaining_warranty); 
                    $('#edit_gps_plan_start_date').val(response.data.gps_plan_start_date); 
                    
                    $('#edit_gps_plan_validity').val(response.data.gps_plan_validity);
                    $('#edit_gps_plan_renew_date').val(response.data.gps_plan_renew_date);
                    $('#edit_gps_device_cost').val(response.data.gps_device_cost);
                    $('#edit_gps_plan_cost').val(response.data.gps_plan_cost);
    
                    $('#editGPS').modal('show');
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
    
            error: function (xhr) {
                console.log(xhr.responseText); // 
                Toast.fire({
                    icon: 'error',
                    title: 'Request failed. Check console.'
                });
            }
        });
    
    });
    
    
    $(document).on('click', '#editGPSBtn', function () {
        $('#editGPSForm').submit();
    });
    
    $('#editGPSForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
        //$('.is-invalid').removeClass('is-invalid');
    
        $('#editGPSBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#editGPSBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#editGPSBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Add invalid class
                    //$input.addClass('is-invalid');
    
                    // Handle Select2
                    // if ($input.hasClass('select2')) {
                    //     $input.next('.select2-container').find('.select2-selection')
                    //         .addClass('is-invalid');
                    // }
    
                    // Show error in <small>
                    let errorId = `#edit_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    // Add/Edit GPS Ends -------------------------------------------------------
    
    
    
    // Add/Edit Fasttag Start --------------------------------------------------
    $(document).on('click', '#addFasttagBtn', function () {
        $('#addFasttagForm').submit();
    });
    
    $('#addFasttagForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
    
        $('#addFasttagBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#addFasttagBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#addFasttagBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#add_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    $(document.body).on('click', '.editFasttag', function () {

        let recordId = $(this).data('id');
    
        $.ajax({
            url: EDIT_FASTTAG.replace(':id', recordId),
            method: 'GET',
            dataType: 'json',
    
            success: function (response) { console.log(response);
                if (response.success) {
    
                    $('#edit_fasttagid_input').val(response.data.id);
                    $('#edit_fasttag_provider_id').val(response.data.fasttagprovider_id).trigger('change');
                    $('#edit_fasttag_bank_name').val(response.data.fasttag_bank_name);
                    $('#edit_fasttag_id').val(response.data.fasttagId); 
                    $('#edit_fasttag_issue_date').val(response.data.fasttag_issue_date); 
    
                    $('#editFasttag').modal('show');
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
    
            error: function (xhr) {
                console.log(xhr.responseText); // 
                Toast.fire({
                    icon: 'error',
                    title: 'Request failed. Check console.'
                });
            }
        });
    
    });
    
    
    $(document).on('click', '#editFasttagBtn', function () {
        $('#editFasttagForm').submit();
    });
    
    $('#editFasttagForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
        //$('.is-invalid').removeClass('is-invalid');
    
        $('#editFasttagBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#editFasttagBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#editFasttagBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Add invalid class
                    //$input.addClass('is-invalid');
    
                    // Handle Select2
                    // if ($input.hasClass('select2')) {
                    //     $input.next('.select2-container').find('.select2-selection')
                    //         .addClass('is-invalid');
                    // }
    
                    // Show error in <small>
                    let errorId = `#edit_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    // Add/Edit Fasttag Ends ---------------------------------------------------
    
    
    
    
    // Add/Edit Tyre Start -----------------------------------------------------
    $(document).on('click', '#addTyreBtn', function () {
        $('#addTyreForm').submit();
    });
    
    $('#addTyreForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
    
        $('#addTyreBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#addTyreBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#addTyreBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#add_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    
    $(document.body).on('click', '.editTyre', function () {

        let recordId = $(this).data('id');
    
        $.ajax({
            url: EDIT_TYRE.replace(':id', recordId),
            method: 'GET',
            dataType: 'json',
    
            success: function (response) { console.log(response);
                if (response.success) {
    
                    $('#edit_tyreid_input').val(response.data.id);
                    $('#edit_tyre_model_name').val(response.data.tyre_model);
                    $('#edit_tyre_type').val(response.data.tyre_type).trigger('change');
                    $('#edit_tyre_brand').val(response.data.tyre_brand);
                    $('#edit_tyre_price').val(response.data.tyre_price); 
                    $('#edit_tyre_serial_number').val(response.data.tyre_serial_number); 
                    $('#edit_tyre_position').val(response.data.tyre_position); 
                    $('#edit_tyre_purchase_date').val(response.data.tyre_purchase_date);  
                    $('#edit_tyre_issue_date').val(response.data.tyre_issue_date);
                    $('#edit_tyre_warranty_months').val(response.data.tyre_warranty_months);
                    $('#edit_fixed_run_km').val(response.data.fixed_run_km);
                    $('#edit_fixed_life_months').val(response.data.fixed_life_months);
                    $('#edit_actual_run_km').val(response.data.actual_run_km);
                    $('#edit_actual_run_month').val(response.data.actual_run_month);
                    $('#edit_remaining_run_km').val(response.data.remaining_run_km);
                    $('#edit_remaining_life_month').val(response.data.remaining_life_month);
                    $('#edit_alignment_interval_km').val(response.data.alignment_interval_km);
                    $('#edit_rotation_interval_km').val(response.data.rotation_interval_km);
                    $('#edit_last_alignment_km').val(response.data.last_alignment_km);
                    $('#edit_last_rotation_km').val(response.data.last_rotation_km);
                    
                    if (response.data.set_reminder_for_alignment == 1) {
                        $('#edit_set_reminder_for_alignment').prop('checked', true);
                    } else {
                        $('#edit_set_reminder_for_alignment').prop('checked', false);
                    }
                    
                    if (response.data.set_reminder_for_rotation == 1) {
                        $('#edit_set_reminder_for_rotation').prop('checked', true);
                    } else {
                        $('#edit_set_reminder_for_rotation').prop('checked', false);
                    }
                    
                    $('#editTyre').modal('show');
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
    
            error: function (xhr) {
                console.log(xhr.responseText); // 
                Toast.fire({
                    icon: 'error',
                    title: 'Request failed. Check console.'
                });
            }
        });
    
    });
    
    
    $(document).on('click', '#editTyreBtn', function () {
        $('#editTyreForm').submit();
    });
    
    $('#editTyreForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
        //$('.is-invalid').removeClass('is-invalid');
    
        $('#editTyreBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#editTyreBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#editTyreBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#edit_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    
    $(document.body).on('click', '.deleteTyre', function () {
        var recordId = $(this).data('id');
    
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure to delete?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete.',
            reverseButtons: true,
            width: '400px',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', recordId);
    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: DELETE_TYRE, // Make sure this is defined
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        location.reload(true); // or remove the row from the table dynamically
                    },
                    error: function (xhr) {
                        var response = $.parseJSON(xhr.responseText);
                        Toast.fire({
                            icon: 'error',
                            title: response.message || 'An error occurred.'
                        });
                    }
                });
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'No action taken.'
                });
            }
        });
    });
    
    // Add/Edit Tyre Ends ------------------------------------------------------
    
    
    
    
    
    // Add/Edit Battery Start --------------------------------------------------
    $(document).on('click', '#addBatteryBtn', function () {
        $('#addBatteryForm').submit();
    });
    
    $('#addBatteryForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
    
        $('#addBatteryBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#addBatteryBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#addBatteryBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#add_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    $(document.body).on('click', '.editBattery', function () {

        let recordId = $(this).data('id');
    
        $.ajax({
            url: EDIT_BATTERY.replace(':id', recordId),
            method: 'GET',
            dataType: 'json',
    
            success: function (response) { console.log(response);
                if (response.success) {
    
                    $('#edit_batteryid_input').val(response.data.id);
                    $('#edit_battery_model_name').val(response.data.battery_model_name);
                    $('#edit_battery_capacity').val(response.data.battery_capacity);
                    $('#edit_battery_brand').val(response.data.battery_brand);
                    $('#edit_battery_price').val(response.data.battery_price); 
                    $('#edit_battery_serial_number').val(response.data.battery_serial_number); 
                    $('#edit_battery_purchase_date').val(response.data.purchase_date); 
                    $('#edit_battery_issue_date').val(response.data.issue_date);  
                    $('#edit_battery_warranty_months').val(response.data.warranty_months);
                    $('#edit_battery_remaining_warranty_months').val(response.data.remaining_warranty_months);
                    $('#edit_battery_fixed_life_months').val(response.data.fixed_life_months);
                    $('#edit_battery_remaining_life_months').val(response.data.remaining_life_months);
                    
                    $('#editBattery').modal('show');
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
    
            error: function (xhr) {
                console.log(xhr.responseText); // 
                Toast.fire({
                    icon: 'error',
                    title: 'Request failed. Check console.'
                });
            }
        });
    
    });
    
    
    $(document).on('click', '#editBatteryBtn', function () {
        $('#editBatteryForm').submit();
    });
    
    $('#editBatteryForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
    
        $('#editBatteryBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#editBatteryBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#editBatteryBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#edit_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    $(document.body).on('click', '.deleteBattery', function () {
        var recordId = $(this).data('id');
    
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure to delete?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete.',
            reverseButtons: true,
            width: '400px',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', recordId);
    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: DELETE_BATTERY, // Make sure this is defined
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        location.reload(true); // or remove the row from the table dynamically
                    },
                    error: function (xhr) {
                        var response = $.parseJSON(xhr.responseText);
                        Toast.fire({
                            icon: 'error',
                            title: response.message || 'An error occurred.'
                        });
                    }
                });
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'No action taken.'
                });
            }
        });
    });
    
    // Add/Edit Battery Ends ---------------------------------------------------
    
    
    
    // Add/Edit Digital Lock Start ---------------------------------------------
    $(document).on('click', '#addDigitalLockBtn', function () {
        $('#addDigitalLockForm').submit();
    });
    
    $('#addDigitalLockForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
    
        $('#addDigitalLockBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#addDigitalLockBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#addDigitalLockBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#add_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    
    $(document.body).on('click', '.editDigitalLock', function () {

        let recordId = $(this).data('id');
    
        $.ajax({
            url: EDIT_DIGITAL_LOCK.replace(':id', recordId),
            method: 'GET',
            dataType: 'json',
    
            success: function (response) { console.log(response);
                if (response.success) {
    
                    $('#edit_digiLockid_input').val(response.data.id);
                    $('#edit_digitallock_provider_id').val(response.data.digitallockprovider_id).trigger('change');
                    $('#edit_lock_id').val(response.data.lockId);
                    $('#edit_lock_issue_date').val(response.data.lock_issue_date);
                    $('#edit_lock_warranty_months').val(response.data.lock_warranty_months); 
                    
                    $('#editDigitalLock').modal('show');
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
    
            error: function (xhr) {
                console.log(xhr.responseText); // 
                Toast.fire({
                    icon: 'error',
                    title: 'Request failed. Check console.'
                });
            }
        });
    
    });
    
    
    $(document).on('click', '#editDigitalLockBtn', function () {
        $('#editDigitalLockForm').submit();
    });
    
    $('#editDigitalLockForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
        //$('.is-invalid').removeClass('is-invalid');
    
        $('#editDigitalLockBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#editDigitalLockBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#editDigitalLockBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Add invalid class
                    //$input.addClass('is-invalid');
    
                    // Handle Select2
                    // if ($input.hasClass('select2')) {
                    //     $input.next('.select2-container').find('.select2-selection')
                    //         .addClass('is-invalid');
                    // }
    
                    // Show error in <small>
                    let errorId = `#edit_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    
    $(document.body).on('click', '.deleteDigitalLock', function () {
        var recordId = $(this).data('id');
    
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure to delete?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete.',
            reverseButtons: true,
            width: '400px',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', recordId);
    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: DELETE_DIGITAL_LOCK, // Make sure this is defined
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        location.reload(true); // or remove the row from the table dynamically
                    },
                    error: function (xhr) {
                        var response = $.parseJSON(xhr.responseText);
                        Toast.fire({
                            icon: 'error',
                            title: response.message || 'An error occurred.'
                        });
                    }
                });
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'No action taken.'
                });
            }
        });
    });
    
    // Add/Edit Digital Lock Ends ----------------------------------------------
    
    
    
    
    // Add/Edit Finance Start --------------------------------------------------
    
    // Reminder Toggle
    $("#setReminder").on("change", function () {
        if ($(this).is(":checked")) {
            $(".days-beforeexpiry").slideDown();
        } else {
            $(".days-beforeexpiry").slideUp();
            $("#emi_reminder_before_days").val('');
        }
    });
    
    
    $(document).on("click", ".AddNewFinance", function () {
        let financeType = $(this).data("financetype");
        //console.log(financeType); 
        
        $(".showfinancetype").text(`(${financeType})`);
        
        $('#finance_type_input').val(financeType);
    });
    
    
    // Calculation Of EMI Section
    
    function calculateEMI(container) {

        let principal = parseFloat(container.find(".emi-principal").val()) || 0;
        let totalAmount = parseFloat(container.find(".emi-total-amount").val()) || 0;
        let months = parseInt(container.find(".emi-months").val()) || 0;
        let paidMonths = parseInt(container.find(".emi-paid-months").val()) || 0;
    
        // Interest
        let interest = totalAmount - principal;
        container.find(".emi-interest").val(interest > 0 ? interest.toFixed(2) : 0);
    
        // EMI
        if (months > 0 && totalAmount > 0) {
            let emi = totalAmount / months;
            container.find(".emi-amount").val(emi.toFixed(2));
        } else {
            container.find(".emi-amount").val('');
        }
    
        // Left Months
        let leftMonths = months - paidMonths;
        container.find(".emi-left-months").val(leftMonths >= 0 ? leftMonths : 0);
    }
    
    $(document).on("keyup change", 
        ".emi-principal, .emi-total-amount, .emi-months, .emi-paid-months",
        function () {
            let container = $(this).closest("form");
            calculateEMI(container);
        }
    );
    
    function calculateEndDate(container) {
        let startDate = container.find(".emi-start-date").val();
        let months = parseInt(container.find(".emi-months").val());
    
        if (startDate && months > 0) {
            let date = new Date(startDate);
            date.setMonth(date.getMonth() + months);
    
            let endDate = date.toISOString().split('T')[0];
            container.find(".emi-end-date").val(endDate);
        }
    }
    
    $(document).on("change", ".emi-start-date, .emi-months", function () {
        let container = $(this).closest("form");
        calculateEndDate(container);
    });
    
    
    $(document).on("keyup change", ".emi-interest, .emi-principal", function () {
        let container = $(this).closest("form");
    
        let principal = parseFloat(container.find(".emi-principal").val()) || 0;
        let interest = parseFloat(container.find(".emi-interest").val()) || 0;
    
        let total = principal + interest;
        container.find(".emi-total-amount").val(total.toFixed(2));
    });
    
    
    $(document).on("change", ".emi-paid-months", function () {
        let container = $(this).closest("form");
    
        let paid = parseInt($(this).val()) || 0;
        let total = parseInt(container.find(".emi-months").val()) || 0;
    
        if (paid > total) {
            $(this).val(total);
        }
    });

    
    
    
    
    
    $(document).on('click', '#addVehicleEmiBtn', function () {
        $('#addVehicleEmiForm').submit();
    });
    
    $('#addVehicleEmiForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
    
        $('#addVehicleEmiBtn').html('<div class="spinner-border spinner-border-sm" role="status"></div>').attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#addVehicleEmiBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#addVehicleEmiBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#add_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    
    
    function toggleReminder() {
        if ($('#edit_set_emi_reminder').is(':checked')) {
            $('.days-beforeexpiry').show();
        } else {
            $('.days-beforeexpiry').hide();
        }
    }
    
    // on change
    $('#edit_set_emi_reminder').on('change', toggleReminder);
    
    // on page load / modal open
    toggleReminder();


    $(document.body).on('click', '.ViewFinance', function () {

        let recordId = $(this).data('id');
    
        $.ajax({
            url: EDIT_FINANCE.replace(':id', recordId),
            method: 'GET',
            dataType: 'json',
    
            success: function (response) { console.log(response);
                if (response.success) {
                    
                    $(".showfinancetype").text(`(${response.data.type})`);
        
                    $('#edit_emi_id_input').val(response.data.id);
                    $('#edit_finance_type_input').val(response.data.type);
                    $('#edit_finance_provider_id').val(response.data.financeprovider_id).trigger('change');
                    $('#edit_loan_account_number').val(response.data.loan_account_no);
                    $('#edit_total_financer_amount').val(response.data.total_financer_amount);
                    $('#edit_total_amount_with_interest').val(response.data.total_amt_with_interest); 
                    $('#edit_emi_amount').val(response.data.emi_amount); 
                    $('#edit_interest_amount').val(response.data.interest_amount); 
                    
                    $('#edit_emi_total_months').val(response.data.total_months);
                    $('#edit_emi_paid_upto_months').val(response.data.paid_upto_months);
                    
                    let total = parseInt(response.data.total_months) || 0;
                    let paid  = parseInt(response.data.paid_upto_months) || 0;
                    
                    let left = Math.max(total - paid, 0);

                    $('#edit_emi_left_months').val(left);
                    $('#edit_emi_start_date').val(response.data.emi_start_date);
                    $('#edit_emi_end_date').val(response.data.emi_end_date);
                    $('#edit_emi_date_of_every_month').val(response.data.emi_date_every_month).trigger('change');
                    $('#edit_emi_notes').val(response.data.notes);
                    
                    if (response.data.set_reminder === 'Yes') {
                        $('#edit_set_emi_reminder').prop('checked', true); 
                        
                        $('.days-beforeexpiry').show();
                        $('#edit_emi_reminder_before_days').val(response.data.emi_reminder_before_days);
                    } else {
                        $('#edit_set_emi_reminder').prop('checked', false);
                    }
                    
    
                    $('#edit_finance').modal('show');
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
    
            error: function (xhr) {
                console.log(xhr.responseText); 
                Toast.fire({
                    icon: 'error',
                    title: 'Request failed. Check console.'
                });
            }
        });
    
    });
    
    
    $(document).on('click', '#editVehicleEmiBtn', function () {
        $('#editVehicleEmiForm').submit();
    });
    
    $('#editVehicleEmiForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
        //$('.is-invalid').removeClass('is-invalid');
    
        $('#editVehicleEmiBtn')
            .html('<div class="spinner-border spinner-border-sm" role="status"></div>')
            .attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#editVehicleEmiBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#editVehicleEmiBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#edit_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    
    
    
    
    
    
    // Store Finance Notes 
    $(document.body).on('click', '.addFinanceNotes', function () {
        let emiId = $(this).data('emiid');
        let loanaccountId = $(this).data('loanaccountid');
        
        $('#loanaccount_cron_given_emi_id').val(loanaccountId);
    });
    
    
    $(document).on('change', '.paymentRecordType', function () {
        let value = $(this).val();
    
        if (value === 'Extra Charge') {
            $('.ExtraChargeDiv').show();
            $('.NotesDiv').hide();
        } else if (value === 'Note') {
            $('.NotesDiv').show();
            $('.ExtraChargeDiv').hide();
        }
    });
    
    
    $(document).on('click', '#addRecordNotesBtn', function () {
        $('#addRecordNotesForm').submit();
    });
    
    $('#addRecordNotesForm').on('submit', function (e) {
        e.preventDefault();
    
        let form = this;
        let formData = new FormData(form);
    
        // Clear old errors
        $('.error').text('');
    
        $('#addRecordNotesBtn').html('<div class="spinner-border spinner-border-sm" role="status"></div>').attr('disabled', true);
    
        $.ajax({
            method: 'POST',
            url: $(form).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (res) {
    
                Toast.fire({
                    icon: 'success',
                    title: res.message || 'Saved successfully!'
                });
    
                $('#addRecordNotesBtn').html('Save').attr('disabled', false);
    
                // reload or update UI
                location.reload(true);
            },
    
            error: function (xhr) {
    
                $('#addRecordNotesBtn').html('Save').attr('disabled', false);
    
                let res = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: res?.message || 'Please check validation error.'
                });
    
                let errors = res?.data || {};
    
                $.each(errors, function (field, messages) {
    
                    let nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    let $input = $(`[name="${nameAttr}"]`);
    
                    // Show error in <small>
                    let errorId = `#add_${field}_error`;
                    $(errorId).text(messages[0]);
                });
    
                // Scroll to first error (optional UX)
                let firstError = $('.error').filter(function () {
                    return $(this).text() !== '';
                }).first();
    
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 300);
                }
            }
        });
    });
    
    
    
    $(document.body).on('click', '.viewFinanceNotes', function () {
        let emiId = $(this).data('emiid');
        let loanaccountId = $(this).data('loanaccountid');
        
        $('#financeNotesTable').html('<tr><td colspan="3">Loading...</td></tr>');
        
        $.ajax({
            url: VIEW_FINANCE_NOTES.replace(':id', loanaccountId),
            type: 'GET',
            success: function (response) {
    
                if (response.success) {
    
                    let rows = '';
    
                    if (response.data.length > 0) {
                        response.data.forEach(function (item) {
                            rows += `<tr>
                                <td>${item.extra_charge ?? '-'}</td>
                                <td>${item.comment ?? '-'}</td>
                            </tr>`;
                        });
                    } else {
                        rows = `<tr><td colspan="2">No data found</td></tr>`;
                    }
    
                    $('#financeNotesTable').html(rows);
                }
            }
        });
        
    });
    
    // Add/Edit Finance Ends ---------------------------------------------------
    
    
    
    // Add Comment Starts ------------------------------------------------------
    
    const noteInput = document.getElementById('noteInput');
    noteInput.addEventListener('input', function () {
        this.style.height = 'auto'; // reset height
        this.style.height = (this.scrollHeight) + 'px'; // set new height
    });
    
    $('form#commentForm').on('submit', function(e){
        e.preventDefault();
        
        $('.error').html('');
        let submitBtn = $('.submitBtn', $(this));
        let submitBtnText = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        var formData = new FormData(this);
        
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                Toast.fire({
                  icon: 'success',
                  title: response.message,
                  didClose: function(){
                    // window.location.href = response.redirect_url;
                    location.reload(true);
                  }
                });
                
                submitBtn.html(submitBtnText);
            },
            error       : function(data){
                var response = data.responseJSON;
                
                Toast.fire({
                  icon: 'error',
                  title: response.message
                });
                
                $.each(response.data, function(index, value){
                    $('#'+index+'_error').text(value[0]);
                });
                
                submitBtn.html(submitBtnText).attr('disabled', false);
            }

        });
        
        return false;
    });
    
    // Add Comment Ends --------------------------------------------------------
    
    
    
    
    
    // Add Document Starts -----------------------------------------------------
    
    $('#doc_issue_date').daterangepicker({
        singleDatePicker: true,   
        timePicker: false,        
        locale: {
          format: 'DD/MM/YYYY',   
        }
    });
    
    
    $('#doc_expiry_date').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        }
    });

    $('#doc_expiry_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });

    $('#doc_expiry_date').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
    
    $('#edit_doc_issue_date').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
        }
    });
    
    $('#edit_doc_expiry_date').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        }
    });
    
    $('#edit_doc_issue_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    
    $('#edit_doc_expiry_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    
    $('#edit_doc_expiry_date').on('cancel.daterangepicker', function () {
        $(this).val('');
    });
    
    $(document).on('click', '.docSubmitForm', function(){
        $('form#documentForm').submit();
    });
    
    $(document).on('click', '.editDocSubmitForm', function(){
        $('form#editDocumentForm').submit();
    });
    
    $('form#documentForm').on('submit', function(e){
        e.preventDefault();
        
        $('.error').html('');
        let submitBtn = $('.docSubmitForm');
        let submitBtnText = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        var formData = new FormData(this);
        
        if($('#myDropzone').length){
            for (let i = 0; i < dzInstance.files.length; i++) {
                formData.append("files[]", dzInstance.files[i]); // Append each file properly
            }
        }
        
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                Toast.fire({
                  icon: 'success',
                  title: response.message,
                  didClose: function(){
                    // window.location.href = response.redirect_url;
                    location.reload(true);
                  }
                });
                
                submitBtn.html(submitBtnText);
            },
            error       : function(data){
                var response = data.responseJSON;
                
                Toast.fire({
                  icon: 'error',
                  title: response.message
                });
                
                $.each(response.data, function(index, value){
                    $('#document_'+index+'_error').text(value[0]);
                });
                
                submitBtn.html(submitBtnText).attr('disabled', false);
            }

        });
        
        return false;
    });
    
    $('form#editDocumentForm').on('submit', function(e){
        e.preventDefault();
        
        $('.error').html('');
        let submitBtn = $('.editDocSubmitForm');
        let submitBtnText = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        var formData = new FormData(this);
        
        if($('#edit_myDropzone').length){
            for (let i = 0; i < editDzInstance.files.length; i++) {
                formData.append("files[]", editDzInstance.files[i]); // Append each file properly
            }
        }
        
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                Toast.fire({
                  icon: 'success',
                  title: response.message,
                  didClose: function(){
                    // window.location.href = response.redirect_url;
                    location.reload(true);
                  }
                });
                
                submitBtn.html(submitBtnText);
            },
            error       : function(data){
                var response = data.responseJSON;
                
                Toast.fire({
                  icon: 'error',
                  title: response.message
                });
                
                $.each(response.data, function(index, value){
                    $('#document_'+index+'_error').text(value[0]);
                });
                
                submitBtn.html(submitBtnText).attr('disabled', false);
            }

        });
        
        return false;
    });
    
    
    
    $('#attachmenttype_dd').select2({
        placeholder: "Search Document Type...",
        dropdownParent: '#documentForm',
        tags: true
    });
    
    $('#edit_attachmenttype_dd').select2({
        placeholder: "Search Document Type...",
        dropdownParent: $('#edit_documents'), 
        tags: true
    });
    
    $('.showMore').on('click', function () {
        const __this = $(this);
        var notes = __this.data('notes');

        $('#modalNotesContent').text(notes); // safe (plain text)
    });
    
    
    $(document).on('click', '.item-edit', function () {

        let button = $(this);
        let value = button.data('attachment_type');
    
        $('#editDocumentForm').attr('action', button.data('url'));
    
        // WAIT UNTIL MODAL IS FULLY OPEN
        $('#edit_documents').off('shown.bs.modal').on('shown.bs.modal', function () {
    
            let $select = $('#edit_attachmenttype_dd');
    
            console.log("VALUE:", value); // debug
    
            // Ensure option exists
            if ($select.find("option[value='" + value + "']").length === 0) {
                let newOption = new Option(value, value, true, true);
                $select.append(newOption);
            }
    
            // THIS WILL WORK NOW
            $select.val(value).trigger('change.select2');
    
        });
    
        // Other fields (these are fine)
        $('input[name="document_number"]').val(button.data('document_number'));
        $('#edit_doc_issue_date').val(button.data('issue_date'));
        $('#edit_doc_expiry_date').val(button.data('expiry_date'));
        $('#edit_document_notes').val(button.data('notes'));
    
        setDateRangePicker('#edit_doc_issue_date', button.data('issue_date'));
        setDateRangePicker('#edit_doc_expiry_date', button.data('expiry_date'));
    
        let hasReminder = button.data('has_reminder');
    
        if (hasReminder == 'Yes') {
            $('#edit_setReminder').prop('checked', true);
            $('.days-beforeexpiry').show();
            $('#edit_reminder_days').val(button.data('reminder_days'));
        } else {
            $('#edit_setReminder').prop('checked', false);
            $('.days-beforeexpiry').hide();
            $('#edit_reminder_days').val('');
        }
    
    });
    
    
    
    
    
    $('#edit_setReminder').on('change', function () {
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').show();
        } else {
            $('.days-beforeexpiry').hide();
            $('#edit_reminder_days').val('');
        }
    });
    
    
    $(document).on('click', '.view-files', function () { 
        let files = $(this).data('files');
        let container = $('#filePreviewContainer1');
    
        container.html(''); // clear previous
    
        if (!files || files.length === 0) {
            container.html('<p>No files available</p>');
            return;
        }
    
        files.forEach(file => {
    
            let isImage = file.file_type.startsWith('image/');
            let isPdf = file.file_type === 'application/pdf';
    
            let previewHtml = '';
            let fileSize = (file.file_size / 1024).toFixed(2) + ' KB';
    
            let createdAt = new Date(file.created_at);
            let formattedDate = createdAt.toLocaleDateString('en-GB');
    
            if (isImage) {
                previewHtml = `<img src="${file.url}" class="me-3" style="width:50px;height:50px;object-fit:cover;">`;
            }else if (isPdf) {
                previewHtml = `<img src="${PDF_LOGO}" 
                                    class="me-3" style="width:50px;">`;
            }else {
                previewHtml = `<img src="${OTHER_LOGO}" 
                                    class="me-3" style="width:50px;">`;
            }
            
            let fileName = file.file_name;
            let shortName = fileName.length > 15 
                            ? fileName.substring(0, 15) + '...' 
                            : fileName;
    
            let html = `
                <div class="col-12 col-md-4 attachment-box mb-3">
                    <div class="preview-img d-block w-100 border rounded p-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <a href="${file.url}" download="${file.file_name}">
                                    ${previewHtml}
                                </a>
                                <div style="font-size: 14px;">
                                    <a href="${file.url}" download="${file.file_name}">
                                        <p class="mb-0 file-name">${shortName}</p>
                                    </a>
                                    <p class="mb-0">Size: 
                                        <span class="text-secondary">${fileSize}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="float-end">
                                <i class="uil-trash-alt text-danger delete-attachment-btn"
                                   data-url="${file.delete_url}"
                                   style="cursor:pointer;"></i>
                            </div>
                        </div>
                        <small class="text-secondary d-block mt-2">
                            Attached on ${formattedDate}
                        </small>
                    </div>
                </div>
            `;
    
            container.append(html);
        });
    
        $('#filePreviewModal').modal('show');
    });
    
    
    
    $(document.body).on('click', '.delete-attachment-btn', function(){
        var url = $(this).data('url');
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Are you sure to delete it?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete',
            confirmButtonColor:'#1F75A8',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method      : 'POST',
                    data        : {},
                    url         : url,
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        Toast.fire({
                                      icon: 'success',
                                      title: response.message
                                }).then(() => {
                                    location.reload(true);
                                });
                            
                    },
                    error       : function(data){
                        var response = $.parseJSON(data.responseText);
                        Toast.fire({
                          icon: 'error',
                          title: response.message
                        });
                        
                    }
                });
            } else {
                Toast.fire({
                  icon: 'info',
                  title: 'No action taken.'
                });
            }
        });
    });
    
    
    $('.clickto-adclass').change(function(){
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').addClass('active');
        } else {
            $('.days-beforeexpiry').removeClass('active');
        }
    });
    
    $('.if-main').click(function(){
        $('.maintanance-wrap').show();
        $('.repair-wrap').hide();
    })
    
    $('.if-rep').click(function(){
        $('.maintanance-wrap').hide();
        $('.repair-wrap').show();
    })
    
    
    
    // Add Document Ends -------------------------------------------------------
    
    
    
    
    
    
    
    
    
    
    
    
});



