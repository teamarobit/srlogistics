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

    $('#contract-pricing').on('shown.bs.modal', function () {
        $(this).find('.select2').select2({
            dropdownParent: $('#contract-pricing'),
            width: '100%'
        });
        $('.if-loading').click(function(){
            $('.loading-wrap').show();
            $('.unloading-wrap').hide();
        })
        $('.if-unloading').click(function(){
            $('.unloading-wrap').show();
            $('.loading-wrap').hide();
        })
    });
    
    $('.select2-modal').select2({
        dropdownParent: $('#vehAllocation') // or any other element within the modal
    });
    
    let activeTab = sessionStorage.getItem('activeTab');
    if (activeTab) {
        $('#pills-tab button[data-bs-target="' + activeTab + '"]').tab('show');
        sessionStorage.removeItem('activeTab');
    }
    
    
    $(document).on('change', '.contact-status', function () {
        if ($(this).val() === 'Blacklisted') {
            $('.statusblacklist').removeClass('d-none');
        } else {
            $('.statusblacklist').addClass('d-none');
        }
    });
    
    
    
    
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
    
    var contactperson_rowindex = $('#contactPersonContainer input[name^="contact_person_name"]').length - 1;
    console.log("c:- " + contactperson_rowindex);
    
    $(document).on('click', '.add-person', function (e) {
        e.preventDefault();
    
        contactperson_rowindex++;
    
        console.log("n:- " + contactperson_rowindex);
    
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
    
                    const container = $('#contactPersonContainer');
                    const $newSection = $(response.data);
    
                    container.append($newSection);
    
                    // re-init select2
                    $newSection.find('.select2').select2();
    
                    // re-init intl-tel-input ONLY for new section
                    initTelInputs($newSection);
    
                    // assign correct error ids
                    assignContactPersonErrorIds("edit", $newSection);
                }
            }
        });
    });


    $(document).on('click', '.close-sec', function (e) {
        e.preventDefault();
        $(this).closest('.contact-person').remove();
    });
    
    
    // Assign correct error IDs
    function assignContactPersonErrorIds(prefix = "edit", container = null) {

        const errorMap = {
            cpnameerr: 'contact_person_name',
            cpdgerr:   'contact_person_designation',
            cpph:      'contact_person_phone',
            cpwa:      'contact_person_whatsapp',
            cpeml:     'contact_person_email',
            cpcmt:     'contact_person_comment'
        };
    
        let scope = container ? container : $(document);
    
        Object.entries(errorMap).forEach(([className, baseName]) => {
    
            scope.find('.' + className).each(function () {
    
                let input = $(this).closest('.contact-person').find(`[name^="${baseName}["]`);
    
                if (input.length) {
    
                    let name = input.attr('name');
                    let match = name.match(/\[(\d+)\]/);
    
                    if (match) {
    
                        let index = match[1];
    
                        $(this).attr('id', `${prefix}_${baseName}_${index}_error`);
                    }
                }
    
            });
    
        });
    
    }
    
    // Add More Contact Person Ends --------------------------------------------
    
    
    
    
    
    
    
    // Same As GST Address Start -----------------------------------------------
    
    $(document).on("change", ".same-as-GST-address", function () {

        const checked = $(this).is(":checked");
    
        // ===== GST VALUES =====
        const gstAddress = $("#gstAddr1").val();
        const gstState   = $("#gstState").val();
        const gstCity    = $("#gstCity").val();
        const gstPin     = $("#gstPin").val();
        const gstComment = $("#contactComment").val();
    
        // ===== BILLING FIELDS =====
        const $billingAddress = $("#billingAddress");
        const $billingState   = $("#billingState");
        const $billingCity    = $("#billingCity");
        const $billingPin     = $("#billingPostalCode");
        $(billingAdditionalInfo).val(gstComment);
    
        if (checked) {
    
            // Copy normal fields
            $billingAddress.val(gstAddress);
            $billingPin.val(gstPin);
    
            // Set STATE → triggers city AJAX
            $billingState.val(gstState).trigger("change");
    
            // Wait until cities are loaded, then set CITY
            let waitForCity = setInterval(function () {
    
                if ($billingCity.find("option").length > 1) {
                    $billingCity.val(gstCity).trigger("change");
                    clearInterval(waitForCity);
                }
    
            }, 150);
    
        } else {
    
            // Unchecked → clear everything
            $billingAddress.val("");
            $billingPin.val("");
    
            $billingState.val("").trigger("change");
            $billingCity.val("").trigger("change");
        }
    });
    
    // Same As GST Address Ends ------------------------------------------------
    
    
    
    
    // Charge button toggle
    $('.dbtn-chargable').click(function(){
        $('.rate-wrap').toggle();
    });

    // Checkbox toggle for charge section
    if ($('.charge-checked').is(':checked')) {
        $('.if-checked').show();
    } else {
        $('.if-checked').hide();
    }
    
    $('.charge-checked').on('change', function () {

        if ($(this).is(':checked')) {
            $('.if-checked').show();
        } else {
            $('.if-checked').hide();
        }
    
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
                    
                    
                    /*$.each(response.data, function(index, value){
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
                    });*/
                    
                    $.each(response.data, function(index, value){

                        let handled = false;
                    
                        // YOUR EXISTING LOGIC (UNCHANGED)
                        if (index.includes('.')) {
                    
                            if(index.split('.').length === 3){
                    
                                $('#edit_' + index.split('.').splice(0,2).join('_') + '_error').text(
                                    Array.isArray(value) ? value.join('') : value
                                );
                                handled = true;
                    
                            } else if(index.split('.').length === 2) {
                    
                                $('#edit_' + index.split('.').join('_') + '_error').text(
                                    Array.isArray(value) ? value.join('') : value
                                );
                                handled = true;
                            }
                    
                        } else {
                    
                            $('#edit_'+index+'_error').text(
                                Array.isArray(value) ? value.join('') : value
                            );
                            handled = true;
                        }
                    
                        // ADD THIS NEW BLOCK (VERY IMPORTANT)
                        if (!handled) {
                    
                            let errorText = Array.isArray(value) ? value[0] : value;
                    
                            let field = index
                                .replace(/\./g, '_')                      // coattachtypes.0 → coattachtypes_0
                                .replace('coattachtypes_', 'coattachtype_'); // match your HTML
                    
                            if ($('#edit_' + field + '_error').length) {
                    
                                $('#edit_' + field + '_error').text(errorText);
                    
                            } else {
                                console.warn('Error element not found:', field);
                            }
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
            $('.LocationTypeBoth').show();
            //$('.LocationTypeBoth').hide();
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
    




    $(document).on('click','#addContactLocationBtn',function(){ 
        $('form#addContactLocationForm').submit();
    });
    
    $('form#addContactLocationForm').on('submit', function(){ 

        // Step 1: Clear previous errors
        $('.error').html('');

        // Step 2: Disable submit button and show spinner
        $('#addContactLocationBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

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
                $('#addContactLocationBtn').html('Save').attr('disabled', false);
                if(response.success){
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#addContactLocationBtn').html('Save').attr('disabled', false);
                    
                    // store tab
                    sessionStorage.setItem('activeTab', '#locations');
                    
                    location.reload(true);
                }
            },
            error: function(xhr){   
                $('#addContactLocationBtn').html('Save').attr('disabled', false);
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
    
    
    $(document).on('change', '#customer_location_type', function () {

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
        $('#customer_location_type').val('').trigger('change');
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
                        
                        // store tab
                        sessionStorage.setItem('activeTab', '#locations');
                    
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    // Contract Section Start --------------------------------------------------
    $('#addNewContractBtn').on('click', function () {

        const hasContract  = $(this).data('has-contract');
        const customerId   = $(this).data('customer-id');
        const createUrl    = $(this).data('create-url');
        const deleteUrl    = $(this).data('delete-url');
        
        window.location.href = createUrl;
        
        
        
        /*
        if (hasContract == 1) {
    
            Swal.fire({
                title: 'Active Contract Found',
                text: 'One of your contracts is active. Do you want to deactivate it and create a new one?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
    
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            customerid: customerId,
                        },
                        success: function (res) {
                            if (res.success) {
                                window.location.href = createUrl;
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Unable to delete contract', 'error');
                        }
                    });
    
                }
            });
    
        } else {
            window.location.href = createUrl;
        }
        */
    });
    

    // Contract Section Ends ---------------------------------------------------
    
    
    
    
    // Contract Pricing Section Start ------------------------------------------
    $(document).on('change', '#customercontract_id', function () {

        let contractId = $(this).val();
        let status = $('#customercontract_id option:selected').data('status');
        let routeDropdown = $('#customercontract_route_id');
    
        routeDropdown.html('<option value="">Choose...</option>').trigger('change');
    
        if (!contractId) return;
        
        function loadRoutes() {

            let finalUrl = CONTRACT_ROUTES.replace(':id', contractId);
    
            $.ajax({
                url: finalUrl,
                type: 'GET',
    
                success: function (response) {
                    console.log(response);
    
                    if (response.success && response.routes.length > 0) {
    
                        let options = '<option value="">Choose...</option>';
    
                        response.routes.forEach(function(route) {
                            options += `
                                <option value="${route.id}" 
                                        data-midpoints="${route.midpoints_count}">
                                    ${route.name.replace(/\s+/g, ' ').trim()}
                                </option>`;
                        });
    
                        routeDropdown.html(options).trigger('change');
    
                    } else {
    
                        Toast.fire({
                            icon: 'warning',
                            title: 'No routes found for selected contract.'
                        });
    
                        routeDropdown.html('<option value="">No routes found</option>').trigger('change');
                    }
                },
    
                error: function (xhr) {
    
                    let message = 'Something went wrong.';
    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
    
                    Toast.fire({
                        icon: 'error',
                        title: message
                    });
                }
            });
        }

        // If contract inactive → ask confirmation
        if (status === 'Inactive') {
    
            Swal.fire({
                title: 'Contract is inactive',
                text: 'Do you still want to select this contract?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, select it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
    
                if (result.isConfirmed) {
                    loadRoutes();
                } else {
                    $('#customercontract_id').val('').trigger('change');
                }
            });
    
        } else {
            loadRoutes();
        }
    
    });
    
    
    
    // ===============================
    // Route Change – Generate Rows
    // ===============================
    $(document).on('change', '#customercontract_route_id', function () {
    
        let selectedOption = $(this).find('option:selected');
        let midpointCount = selectedOption.data('midpoints') || 0;
    
        $('#midpoint_count').val(midpointCount);
    
        let container = $('#midpointContainer');
        container.empty();
    
        if (midpointCount > 0) {
    
            for (let i = 1; i <= midpointCount; i++) {
                container.append(generateMidpointRow(i));
            }
    
            // Initialize Select2 ONLY for new elements
            container.find('.select2').select2({
                width: '100%'
            });
    
            $('#MidpointDiv').show();
    
        } else {
            $('#MidpointDiv').hide();
        }
    
    });


    // ===============================
    // Generate Dynamic Row
    // ===============================
    function generateMidpointRow(index) {

        return `
            <div class="row midpoint-row mb-3">
    
                <div class="col-12 col-md-6 form-group">
                    <label>Midpoint Type ${index}</label>
    
                    <div class="form-check form-check-inline radio-chip">
                        <input class="form-check-input midpoint-type-radio" type="radio" id="loading_${index}" data-index="${index}" name="midpoint_type[${index}]" value="Loading">
                        <label class="form-check-label" for="loading_${index}">Loading</label>
                    </div>
    
                    <div class="form-check form-check-inline radio-chip">
                        <input class="form-check-input midpoint-type-radio" type="radio" id="unloading_${index}" data-index="${index}" name="midpoint_type[${index}]" value="Unloading">
                        <label class="form-check-label" for="unloading_${index}">Unloading</label>
                    </div>
                    
                    <span class="error text-danger midpoint_type_error"></span>
                </div>
    
                <div class="col-12 col-md-6 form-group loading-wrap" style="display:none;">
                    <label>Loading Midpoint</label>
                    <select name="loading_midpoint[${index}]" class="form-select select2 midpoint-select">
                        <option value="">Choose...</option>
                    </select>
                    <span class="error text-danger loading_midpoint_error"></span>
                </div>
    
                <div class="col-12 col-md-6 form-group unloading-wrap" style="display:none;">
                    <label>Unloading Midpoint</label>
                    <select name="unloading_midpoint[${index}]" class="form-select select2 midpoint-select">
                        <option value="">Choose...</option>
                    </select>
                    <span class="error text-danger unloading_midpoint_error"></span>
                </div>
    
            </div>
        `;
    }



    // ===============================
    // Radio Change – Fetch Midpoints
    // ===============================
    $(document).on('change', '.midpoint-type-radio', function () {

        let contact_id = $('#edit_contactid_input').val();
        let type = $(this).val();
        let index = $(this).data('index');
    
        let currentRow = $(this).closest('.midpoint-row');
    
        let loadingWrap = currentRow.find('.loading-wrap');
        let unloadingWrap = currentRow.find('.unloading-wrap');
    
        let loadingSelect = currentRow.find(`select[name="loading_midpoint[${index}]"]`);
        let unloadingSelect = currentRow.find(`select[name="unloading_midpoint[${index}]"]`);
    
        // Destroy select2 if already initialized
        if (loadingSelect.hasClass("select2-hidden-accessible")) {
            loadingSelect.select2('destroy');
        }
    
        if (unloadingSelect.hasClass("select2-hidden-accessible")) {
            unloadingSelect.select2('destroy');
        }
    
        // Reset dropdowns
        loadingSelect.html('<option value="">Loading...</option>');
        unloadingSelect.html('<option value="">Choose...</option>');
    
        $.ajax({
            url: FETCH_MIDPOINTS_URL,
            type: 'POST',
            data: {
                contact_id: contact_id,
                type: type,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) { 

                console.log(response);
    
                if (response.success && response.data.length > 0) {
    
                    let options = '<option value="">Choose...</option>';
    
                    response.data.forEach(function (item) {
                        options += `<option value="${item.id}">${item.location_name}</option>`;
                    });
    
                    if (type === 'Loading') {
    
                        loadingSelect.html(options);
    
                        loadingSelect.select2({
                            width: '100%',
                            dropdownParent: $('#contract-pricing') 
                        });
    
                        loadingWrap.show();
                        unloadingWrap.hide();
    
                    } else {
    
                        unloadingSelect.html(options);
    
                        unloadingSelect.select2({
                            width: '100%',
                            dropdownParent: $('#contract-pricing') 
                        });
    
                        unloadingWrap.show();
                        loadingWrap.hide();
                    }
    
                } else {
    
                    loadingWrap.hide();
                    unloadingWrap.hide();
    
                    Toast.fire({
                        icon: 'warning',
                        title: 'No midpoints found.'
                    });
                }
            },
            error: function () {
    
                loadingWrap.hide();
                unloadingWrap.hide();
    
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to fetch midpoints.'
                });
            }
        });
    });


    
    $(document).on('change', '.midpoint-select', function () {

        if (hasDuplicateMidpoint()) {
    
            Toast.fire({
                icon: 'error',
                title: 'Duplicate midpoint selected. Please choose different locations.'
            });
    
            $('#addContractPricingBtn').prop('disabled', true);
    
        } else {
            $('#addContractPricingBtn').prop('disabled', false);
        }
    
    });

    
    function hasDuplicateMidpoint() {

        let values = [];
        let duplicate = false;
    
        $('.midpoint-select').each(function () {
            let val = $(this).val();
    
            if (val) {
                if (values.includes(val)) {
                    duplicate = true;
                    return false; // break loop
                }
                values.push(val);
            }
        });
    
        return duplicate;
    }
    
    
    
    // For Applicable and Retrospective Date Range
    $('.daterange').each(function() {

        // Determine which range it is
        let isApplicable = $(this).attr('name') === 'applicable_date_range';
        let isRetrospective = $(this).attr('name') === 'retrospective_date_range';

        $(this).daterangepicker({
            opens: 'right',
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        $(this).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(
                picker.startDate.format('YYYY-MM-DD') + ' - ' +
                picker.endDate.format('YYYY-MM-DD')
            );

            // Store start and end dates into hidden inputs
            if (isApplicable) {
                $('.applicable_start_date').val(picker.startDate.format('YYYY-MM-DD'));
                $('.applicable_end_date').val(picker.endDate.format('YYYY-MM-DD'));
            }
            if (isRetrospective) {
                $('.retrospective_start_date').val(picker.startDate.format('YYYY-MM-DD'));
                $('.retrospective_end_date').val(picker.endDate.format('YYYY-MM-DD'));
            }
        });

        $(this).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');

            // Clear hidden inputs as well
            if (isApplicable) {
                $('.applicable_start_date').val('');
                $('.applicable_end_date').val('');
            }
            if (isRetrospective) {
                $('.retrospective_start_date').val('');
                $('.retrospective_end_date').val('');
            }
        });
    });






    toggleVehicleDeleteBtn();
    
    function toggleVehicleDeleteBtn() {

        $('.vehicleRow').each(function(index) {
    
            if (index === 0) {
                $(this).find('.removeVehicleRow').hide();   // first row
            } else {
                $(this).find('.removeVehicleRow').show();   // other rows
            }
    
        });
    
    }
    
    $(document).on('click', '.addNewVehicle', function (e) {

        e.preventDefault(); // prevent accidental submit
    
        let newRow = $('.vehicleRow:first').clone();
    
        newRow.find('select').val('');
        newRow.find('input').val('');
    
        $('.vehicleRows').append(newRow);
        
        toggleVehicleDeleteBtn();
    });
    
    $(document).on('click', '.removeVehicleRow', function () {
        $(document).on('click', '.removeVehicleRow', function () {
            $(this).closest('.vehicleRow').remove();
            toggleVehicleDeleteBtn();
        });
    });

    $(document).on('change', '.vehicleTypeId', function () {

        let typeId = $(this).val();
    
        // Get current row
        let currentRow = $(this).closest('.vehicleRow');
    
        // Get size dropdown only inside this row
        let sizeDropdown = currentRow.find('.vehicleTypeSizeId');
    
        sizeDropdown.html('<option value="">Choose</option>');
    
        if (!typeId) return;
    
        let finalUrl = VEHICLETYPE_SIZES.replace(':id', typeId);
    
        $.ajax({
            url: finalUrl,
            type: 'GET',
            success: function (response) {
    
                if (response.success && response.sizes.length) {
    
                    let options = '<option value="">Choose</option>';
    
                    response.sizes.forEach(function(size) {
                        options += `<option value="${size.id}">
                                        ${size.name}
                                    </option>`;
                    });
    
                    sizeDropdown.html(options);
    
                } else {
                    sizeDropdown.html('<option value="">No sizes found</option>');
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to load vehicle sizes.'
                });
            }
        });
    
    });









    $(document).on('click','#addContractPricingBtn',function(){ 
        $('form#addContractPricingForm').submit();
    });
    
    $('form#addContractPricingForm').on('submit', function(){ 

        // Step 1: Clear previous errors
        $('.error').html('');

        // Step 2: Disable submit button and show spinner
        $('#addContractPricingBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

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
                $('#addContractPricingBtn').html('Save').attr('disabled', false);
                if(response.success){
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#addContractPricingBtn').html('Save').attr('disabled', false);
                    
                    // store tab
                    sessionStorage.setItem('activeTab', '#contract-ricing');
                        
                    location.reload(true);
                }
            },
            
            error: function(xhr){

                $('#addContractPricingBtn').html('Save').attr('disabled', false);
            
                let response = xhr.responseJSON;
            
                if(response && response.data){
            
                    $.each(response.data, function(key, messages){
            
                        let fieldName = key.split('.')[0];
                        let index = key.split('.')[1];
            
                        if(index !== undefined){
            
                            // Handle array fields
                            let field = $('[name="'+fieldName+'[]"]').eq(index);
            
                            if(field.length){
                                field.closest('.form-group').find('.error').text(messages[0]);
                            }
            
                        } else {
            
                            // Handle normal fields
                            $('#add_'+fieldName+'_error').text(messages[0]);
                        }
            
                    });
            
                } else {
                    Toast.fire({ icon: 'error', title: response?.message || 'Something went wrong!!' });
                }
            }
        });

        return false;
    });
    
    
    $(document).on('click', '.labour-charge-btn', function(){

        let pricingId = $(this).data('id');
        let url = LABOUR_CHARGE_URL.replace(':id', pricingId);
    
        $('#labourChargeTableBody').html(
            '<tr><td colspan="4" class="text-center">Loading...</td></tr>'
        );
    
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response){ 
                
                //console.log(response);
                
                // Set header values
                $('#modalUpdatedBy').text(response.updated_by);
                $('#modalUpdatedOn').text(response.updated_on);
    
                let rows = '';
    
                if(response.data.length > 0){

                    $.each(response.data, function(index, item){
                        rows += `
                            <tr>
                                <td>${item.loading_point}</td>
                                <td>${item.unloading_point}</td>
                                <td>${item.paid_by}</td>
                                <td>₹${item.amount}</td>
                            </tr>
                        `;
                    });
            
                } else {
                    rows = '<tr><td colspan="4" class="text-center">No Data Found</td></tr>';
                }
    
                $('#labourChargeTableBody').html(rows);
            },
            error: function(){
                $('#labourChargeTableBody').html(
                    '<tr><td colspan="4" class="text-center text-danger">Something went wrong</td></tr>'
                );
            }
        });
    
    });
    
    
    $(document).on('click', '.vehicle-detail-btn', function(){

        let pricingId = $(this).data('id');
        let url = VEHICLE_DETAIL_URL.replace(':id', pricingId);
    
        $('#vehicleFreightBody').html(
            '<tr><td colspan="2" class="text-center">Loading...</td></tr>'
        );
    
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {

                let rows = '';
    
                if (response.success && response.data.length > 0) {
    
                    $.each(response.data, function (index, item) {
    
                        rows += `
                            <tr>
                                <td><span class="tag">${item.size}</span></td>
                                <td class="text-end">₹ ${item.freight}</td>
                            </tr>
                        `;
                    });
    
                } else {
    
                    rows = `
                        <tr>
                            <td colspan="2" class="text-center">
                                No Data Found!
                            </td>
                        </tr>
                    `;
                }
    
                $('#vehicleFreightBody').html(rows);
            },
            error: function(){
                $('#vehicleFreightBody').html(
                    '<tr><td colspan="2" class="text-center text-danger">Something went wrong</td></tr>'
                );
            }
        });
    
    });
    
    
    $(document).on('click', '.pricing-history-btn', function () {

        let pricingId = $(this).data('id');
        let url = PRICING_HISTORY_URL.replace(':id', pricingId);
    
        $('#pricingHistoryBody').html('<div class="text-center">Loading...</div>');
    
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {

                if (response.status) {
                    $('#pricingHistoryBody').html(response.html);
                } else {
                    $('#pricingHistoryBody').html(response.html);
                }
            
                //$('#pricingHistoryBody').html(content);
            },
            error: function () {
                $('#pricingHistoryBody').html(
                    '<div class="text-center text-danger">Error loading data!</div>'
                );
            }
        });
    });


    // Contract Pricing Section Ends -------------------------------------------
    
    

    // contract-pricing
    $('#contract-pricing').on('shown.bs.modal', function () {
        $(this).find('.select2').select2({
            dropdownParent: $('#contract-pricing'),
            width: '100%'
        });
    });
    // contract-pricing-END
    
    $('input[name="size"]').on('change', function () {

        if ($(this).val() === 'Sourse') {
            $('.source_sec').show();
            $('.destination_sec').hide();
        } 
        else if ($(this).val() === 'Destination') {
            $('.destination_sec').show();
            $('.source_sec').hide();
        }

    });
    
    
    
    
    
    
    
    // Save Vehicle Start ------------------------------------------------------
    $(document).on('click','#addVehicleBtn',function(){ 
        $('form#addVehicleAllocationForm').submit();
    });
    
    $('form#addVehicleAllocationForm').on('submit', function(){ 

        // Step 1: Clear previous errors
        $('.error').html('');

        // Step 2: Disable submit button and show spinner
        $('#addVehicleBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

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
                $('#addVehicleBtn').html('Save').attr('disabled', false);
                if(response.success){
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#addVehicleBtn').html('Save').attr('disabled', false);
                    
                    // store tab
                    sessionStorage.setItem('activeTab', '#vehicle');
                    
                    location.reload(true);
                }
            },
            
            error: function(xhr){

                $('#addVehicleBtn').html('Save').attr('disabled', false);
            
                let response = xhr.responseJSON;
            
                if(response && response.data){
            
                    $.each(response.data, function(key, messages){
            
                        let fieldName = key.split('.')[0];
                        let index = key.split('.')[1];
            
                        if(index !== undefined){
            
                            // Handle array fields
                            let field = $('[name="'+fieldName+'[]"]').eq(index);
            
                            if(field.length){
                                field.closest('.form-group').find('.error').text(messages[0]);
                            }
            
                        } else {
            
                            // Handle normal fields
                            $('#add_'+fieldName+'_error').text(messages[0]);
                        }
            
                    });
            
                } else {
                    Toast.fire({ icon: 'error', title: response?.message || 'Something went wrong!!' });
                }
            }
        });

        return false;
    });
    
    // Save Vehicle Ends -------------------------------------------------------
    
    
    
    
    

    
    
    
    
    // Delete Contract Section Start -------------------------------------------
    
    $(document.body).on('click', '.deleteRecord', function () {
        var recordId = $(this).data('id');
        var actmodelid = $(this).data('actmodelid'); 
    
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
                formData.append('actmodelid', actmodelid);
    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: DELETE_CONTRACT_URL, // Make sure this is defined
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
    
    // Delete Contract Section Ends --------------------------------------------
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});








