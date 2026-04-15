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
const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

const csrfToken = $('meta[name="csrf-token"]').attr('content');

Dropzone.autoDiscover = false;

const dropzones = [];
const MAX_ATTACHMENTS = 4;
let attachmentIndex = 0;

function initDropzone(id) {
    const el = document.getElementById(`dropzone${id}`);
    if (!el) return;

    // Prevent double init
    if (el.dropzone) return;

    if (!window.UPLOAD_URL) {
        console.error("Dropzone cannot initialize: UPLOAD_URL not defined");
        return;
    }

    const dz = new Dropzone(el, {
        url: window.UPLOAD_URL,
        //url: '/upload/images',
        paramName: "file",
        maxFiles: 2,
        maxFilesize: 2,
        acceptedFiles: ".pdf,.jpg,.jpeg,.png",
        addRemoveLinks: true,
        autoProcessQueue: false,
        headers: { "X-CSRF-TOKEN": csrfToken }
    });
    
    // Event: file exceeds max
    dz.on("maxfilesexceeded", function(file) {
        dz.removeFile(file); // Remove the extra file
        Toast.fire({
                      icon: 'error',
                      title: "Maximum 2 attachments allowed!"
                    });
    });

    dropzones.push({ id, dz });
}



// ADD ATTACHMENT
$('#add_attachment_btn').on('click', function () {
    if (dropzones.length >= MAX_ATTACHMENTS) {
        Toast.fire({ icon: "error", title: "Maximum 4 attachments allowed." });
        return;
    }

    attachmentIndex++;

    const formData = new FormData();
    formData.append('rowindex', attachmentIndex);
    formData.append('form_type', 'Edit');

    $(this).prop('disabled', true);

    $.ajax({
        url: window.ATTACHMENT_WRAPPER,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function (res) {
            if (res.success) {
                $('#uploadContainer').append(res.data.formelements);
                initDropzone(res.data.rowindex);
            } else {
                Toast.fire({ icon: "error", title: res.message });
            }
        },
        complete: function () {
            $('#add_attachment_btn').prop('disabled', false);
        }
    });
});

// REMOVE ATTACHMENT
$(document).on('click', '.remove-attachment-btn', function () {
    const indexId = $(this).data('rowindex');

    Swal.fire({
        icon: 'warning',
        title: 'Remove this attachment?',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) return;

        const dzIndex = dropzones.findIndex(d => d.id == indexId);
        if (dzIndex !== -1) {
            dropzones[dzIndex].dz.destroy();
            dropzones.splice(dzIndex, 1);
        }

        $('#hrl_' + indexId).remove();
        $('#attsec_' + indexId).remove();
    });
});


// dropzone end




$(document).ready(function(){
    
    console.log("Initializing dropzone...");
    initDropzone(0);
    
    
    setupDependentSelect('.dependent-select', 'Choose city');
    
    function setupDependentSelect(firstSelectSelector, placeholder = 'Select option...') {

        $(document).on('change', firstSelectSelector, function () {
    
            let $this = $(this);
            let targetId = $this.data('target');
            let $target = $('#' + targetId);
            let url = $this.find(':selected').data('url');
    
            // Reset city
            $target.empty().append(`<option value="">Loading...</option>`);
    
            if (!url) {
                $target.html(`<option value="">${placeholder}</option>`);
                return;
            }
    
            $.ajax({
                url: url,
                type: 'GET',
                success: function (res) {
    
                    // Destroy old Select2
                    if ($target.hasClass("select2-hidden-accessible")) {
                        $target.select2('destroy');
                    }
    
                    $target.empty().append(`<option value="">${placeholder}</option>`);
    
                    $.each(res, function (i, item) {
                        $target.append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                    });
    
                    // Re-init Select2
                    $target.select2({
                        width: '100%'
                    });
                },
                error: function (xhr) {

                    let message = 'Something went wrong.';
                
                    if (xhr.responseJSON) {
                
                        if (xhr.responseJSON.errors) {
                            message = Object.values(xhr.responseJSON.errors)[0][0];
                        } else if (xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                
                    } else if (xhr.responseText) {
                        message = xhr.responseText;
                    }
                
                    Toast.fire({
                        icon: 'error',
                        title: message
                    });
                
                    console.log("AJAX ERROR:", xhr.responseText);
                    //$target.html('<option value="">Error loading cities</option>');
                }
            });
        });
    }
    
    
    
    
    $(document).on('click', '.loadvendor-status', function () {
        if ($(this).val() === 'Blacklisted') {
            $('.statusblacklist').show();
        } else {
            $('.statusblacklist').hide();
        }
    });
    
    
    
    // -------------------------------------------------------------------------
    $(document).on('click', '.edit-attachment-btn', function () {

        let id = $(this).data('id');
    
        $('#attachment_id').val(id);
    
        $('#editAttachmentModal').modal('show');
    
    });
    
    $(document).on("click","#editAttachmentBtn", function(){
        $('form#editAttachmentForm').submit();
    });
    
    $('form#editAttachmentForm').on("submit",function(e){
        
        e.preventDefault();
        
        $button = $('#editAttachmentBtn');
        
        var formData = new FormData(this);
        
        
        $('.error').html('');
        $button.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success: function(response){
                
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
    
                $button.html('Save').attr('disabled', false);
                
                // close modal
                $('#editAttachmentModal').modal('hide');
            
                // reload page after short delay
                setTimeout(function(){
                    location.reload();
                }, 1000);
                
            },
            error: function(data){

                $button.html('Update').attr('disabled', false);
            
                if (data.status === 422) {
            
                    let errors = data.responseJSON.data;
            
                    if (errors.attachment_file) {
                        $('#edit_attachment_file_error').html(errors.attachment_file[0]);
                    }
            
                } else {
            
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong'
                    });
            
                }
            
            }

        });
        
        return false;
    });
    
    
    
    // -------------------------------------------------------------------------
    
    
    // Add More Contact Person Start -------------------------------------------
    
    var contactperson_rowindex = 0;

    $(document).on('click', '.add-person', function (e) {
        e.preventDefault();
    
        contactperson_rowindex++;
    
        var formData = new FormData();
        formData.append('rowindex', contactperson_rowindex);
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: CONTACTPERSON_WRAPPER,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (response) {
                console.log('res:-', response);
                
                if (response.success) {

                    const $newSection = $(response.data);
                    $('#contactPersonContainer').append($newSection);
                
                    $newSection.find('.select2').select2();
                    initTelInputs($newSection);
                
                    assignContactPersonErrorIds(); 
                
                }
    
            }
        });
    });


    $(document).on('click', '.close-sec', function (e) {
        e.preventDefault();
    
        //if ($('.contact-person').length > 1) {
            $(this).closest('.contact-person').remove();
        //}
    });
    
    
    function assignContactPersonErrorIds(prefix = "add") {

        const errorMap = {
            cpnameerr: 'contact_person_name',
            cpdgerr:   'contact_person_designation',
            cpphcd:    'contact_person_ph_code',
            cpph:      'contact_person_phone',
            cpeml:     'contact_person_email',
            cpcmt:     'contact_person_comment'
        };
    
        $('.contact-person').each(function () {
    
            let rowIndex = $(this).data('index'); // use actual row index
    
            Object.entries(errorMap).forEach(([className, baseId]) => {
    
                $(this).find('.' + className).attr(
                    'id',
                    `${prefix}_${baseId}_${rowIndex}_error`
                );
    
            });
    
        });
    }
    
    // Add More Contact Person Ends --------------------------------------------
    
    
    
    // Charge button toggle
    $('.dbtn-chargable').click(function(){
        $('.rate-wrap').toggle();
    });

    // Checkbox toggle for charge section
    $('.charge-checked').click(function(){
        $('.if-checked').toggle();
    });
    
    
    
    // Save contact Start ------------------------------------------------------
    $(document).on("click","#editContactBtn", function(){
        $('form#editContactForm').submit();
    });
    
    $('form#editContactForm').on("submit",function(){
        
        $button = $('#editContactBtn');
        
        var formData = new FormData(this);
        
        let hasFiles = false;
    
        dropzones.forEach(({ dz, id }) => {
            const coattachtype = $(`#coattachtypes_${id}`).val();
    
            // Append document type
            formData.append(`attachtypes[${id}]`, coattachtype);
    
            dz.files.forEach((file, i) => {
                if (file.status !== 'removed') {
                    formData.append(`files[${id}][]`, file);
                    hasFiles = true;
                }
            });
        });
    
        // if (!hasFiles) {
        //     Toast.fire({
        //         icon: "warning",
        //         title: "Please upload at least one file."
        //     });
        //     return false;
        // }

        
        $('.error').html('');
        $button.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                if (response.success === true) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
        
                    $('#editContactBtn').html('Save').attr('disabled', false);
        
                    // redirect after short delay (optional)
                    setTimeout(function(){
                        window.location.href = CONTACTS;
                    }, 1000);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                    $('#editContactBtn').html('Save').attr('disabled', false);
                }
            },
            error       : function(data){
                
                var response = $.parseJSON(data.responseText);
                if(response.success === true){
                    
                    Toast.fire({
                      icon: 'success',
                      title: response.message,
                      didClose: () => {
                          window.location.href = CONTACTS;
                      }
                    });
                    $button.html('Save').attr('disabled', false);
                    
                } else {
                    
                    Toast.fire({
                      icon: 'error',
                      title: response.message
                    });
                    
                    
                    $.each(response.data, function(index, value){
                          if (index.includes('.')) {
                              if(index.split('.').length === 3){
                                    $('#edit_' + index.split('.').splice(0,2).join('_') + '_error').text(
                                      value.join('').replace(index, index.split('.').splice(0,2).join('_'))
                                    );
                              }else if(index.split('.').length === 2) {
                                    $('#edit_' + index.split('.').join('_') + '_error').text(value);
                              }
                          } else {
                                 $('#edit_'+index+'_error').text(value);
                          }
                    });
                    
                    $button.html('Save').attr('disabled', false);
                    
                }
            }

        });
        
        return false;
    });
    // Save contact Ends -------------------------------------------------------
    
    
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
                    dataType    : 'application/json',
                    success     : function(response){
                        attachmentCount--;
                    },
                    error       : function(data){
                        var response = $.parseJSON(data.responseText);
                        if(response.success === true){
                            Toast.fire({
                              icon: 'success',
                              title: response.message
                            });
                            
                            location.reload(true);
                        } else {
                            Toast.fire({
                              icon: 'error',
                              title: response.message
                            });
                            
                        }
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
    
    
    
    
    
    // Save Location Start -----------------------------------------------------
    
    $('#addLocation').on('shown.bs.modal', function () {

        // initialize every select2 inside this popup
        $(this).find('select.select2').each(function () {
            $(this).select2({
                dropdownParent: $('#addLocation'), // attach dropdown to popup
                placeholder: "Choose...",      // optional, set as you like
                allowClear: true,              // optional
                // any other options you use
            });
        });
    
    });
    
    $('input[name="route_type"]').on('change', function () {
        const val = $(this).val();
        
        // hide all first
        $('.source-wrap, .destination-wrap, .midpoint-wrap').hide();

        // show the one that matches the selected value
        if (val === 'source') {
            $('.source-wrap').show();
            $('#company_role_consignor').prop('checked', true).trigger('change');
            $('.LocationTypeBoth').show();
        } else if (val === 'destination') {
            $('.destination-wrap').show();
            $('#company_role_consignee').prop('checked', true).trigger('change');
            $('.LocationTypeBoth').show();
        } else if (val === 'midpoint') {
            $('.midpoint-wrap').show();
            
            $('.LocationTypeBoth').hide();
        }
    });
    
    $(document).on('change', 'input[name="location_type"]', function () {

        let selectedValue = $(this).val();
    
        if (selectedValue === 'Loading') {
            $('#company_role_consignee').prop('checked', false);
            $('#company_role_consignor').prop('checked', true).trigger('change');
            
            $('.LoadingChargeDiv').show();
            $('.UnloadingChargeDiv').hide();
        } 
        else if (selectedValue === 'Unloading') {
            $('#company_role_consignor').prop('checked', false);
            $('#company_role_consignee').prop('checked', true).trigger('change');
            
            $('.UnloadingChargeDiv').show();
            $('.LoadingChargeDiv').hide();
        }
        else if (selectedValue === 'Both') {
            $('.LoadingChargeDiv').show();
            $('.UnloadingChargeDiv').show();
        }
    
    });
    
    
    $(document).on('change', 'input[name="brone_by"]', function () {

        let selectedValue = $(this).val();
    
        if (selectedValue === 'mixed') {
            $('.CappingAmountDiv').show();
        } else {
            $('.CappingAmountDiv').hide();
        }
    
    });
    
    
    
    // capping_amount ≤ loading_charge 
    // capping_amount ≤ unloading_charge
    function validateCapping() {

        let loading = parseFloat($('.locationLoadingCharge').val());
        let unloading = parseFloat($('.locationUnloadingCharge').val());
        let capping = parseFloat($('.locationCappingAmount').val());
    
        // If capping is empty → no validation
        if (isNaN(capping)) {
            return;
        }
    
        let maxAllowed = null;
    
        // Case 1: both exist
        if (!isNaN(loading) && !isNaN(unloading)) {
            maxAllowed = Math.min(loading, unloading);
        }
        // Case 2: only loading exists
        else if (!isNaN(loading)) {
            maxAllowed = loading;
        }
        // Case 3: only unloading exists
        else if (!isNaN(unloading)) {
            maxAllowed = unloading;
        }
        // If neither exists → no validation
        else {
            return;
        }
    
        if (capping > maxAllowed) {
    
            Toast.fire({
                icon: 'error',
                title: 'Capping amount cannot be greater than loading or unloading charge!'
            });
    
            $('.locationCappingAmount').val(maxAllowed);
        }
    }

    $(document).on('input', '.locationCappingAmount', validateCapping);
    $(document).on('input', '.locationLoadingCharge', validateCapping);
    $(document).on('input', '.locationUnloadingCharge', validateCapping);
    




    $(document).on('click','#addLoadvendorLocationBtn',function(){ 
        $('form#addLoadvendorLocationForm').submit();
    });
    
    $('form#addLoadvendorLocationForm').on('submit', function(){ 

        // Step 1: Clear previous errors
        $('.error').html('');

        // Step 2: Disable submit button and show spinner
        $('#addLoadvendorLocationBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

        // Step 3: AJAX submission
        var formData = new FormData(this);
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false,
            contentType : false,
            dataType    : 'json',
            success     : function(response){ 
                $('#addLoadvendorLocationBtn').html('Save').attr('disabled', false);
                if(response.success){
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#addLoadvendorLocationBtn').html('Save').attr('disabled', false);
                    location.reload(true);
                }
            },
            error: function(xhr){   
                $('#addLoadvendorLocationBtn').html('Save').attr('disabled', false);
                let response = xhr.responseJSON;

                if(response && response.data){
                    $.each(response.data, function(key, messages){
                        var inputId = key.replace(/\./g, '_');
                        var $span = $('#add_' + inputId + '_error');
                        if($span.length){
                            $span.text(messages[0]);
                        } else {
                            // Fallback: show as toast
                            Toast.fire({ icon: 'error', title: messages[0] });
                        }
                    });
                } else {
                    Toast.fire({ icon: 'error', title: response?.message || 'Something went wrong!!' });
                }
            }
        });

        return false;
    });
    
    
    
    $(document).on('change', '#loadvendor_location_type', function () {

        let locationType = $(this).val();
        
        let id = $('#edit_contactid_input').val();  

        let finalUrl = FILTER_LOCATION_URL.replace(':id', id);
    
        $.ajax({
            url: finalUrl,
            type: "GET",
            data: {
                location_type: locationType
            },
            beforeSend: function() {
                $('#locationCollapse').html('<div class="text-center p-3">Loading...</div>');
            },
            success: function(response) { console.log(response);
                $('#locationCollapse').html(response);
            }
        });
    
    });
    
    $(document).on('click', '.reset-btn', function () {
        $('#loadvendor_location_type').val('').trigger('change');
    });
    
    
    
    $(document).on('click', '.delete-location', function () {
        var locationid = $(this).data('locationid');
        
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Are you sure to delete?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete.',
            reverseButtons: true,
            //width: '400px',
            customClass: {
                confirmButton: 'btn btn-danger btn-lg me-2',   // adds right margin
                cancelButton: 'btn btn-secondary btn-lg me-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('location_id', locationid); 
    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: DELETE_LOCATION_URL, // Make sure this is defined
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
    // Save Location Ends ------------------------------------------------------
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});








