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
        //url: window.UPLOAD_URL,
        url: '/upload/images',
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
    
    
    // Global Select2 init
    $('.select2').select2({
        width: '100%'
    });
    
    
    
    let activeTab = sessionStorage.getItem('activeTab');
    if (activeTab) {
        $('#pills-tab button[data-bs-target="' + activeTab + '"]').tab('show');
        sessionStorage.removeItem('activeTab');
    }
    
    
    
    $(document).on('click', '.contact-status', function () {
        if ($(this).val() === 'Blacklisted') {
            $('.statusblacklist').show();
        } else {
            $('.statusblacklist').hide();
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
                        width: '100%',
                        dropdownAutoWidth: true
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
    
    
    
    
    // Add More Emergency Contact Person Start -------------------------------------------
    
    var emergency_contactperson_rowindex = 0;

    $(document).on('click', '.add-person', function (e) {
        e.preventDefault();
    
        emergency_contactperson_rowindex++;
    
        var formData = new FormData();
        formData.append('rowindex', emergency_contactperson_rowindex);
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: EMPERGENY_CONTACT_WRAPPER,
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
                    //$newSection.find('.select2').select2();
                    $newSection.find('.select2').select2({
                        width: '100%'
                    });
            
                    // re-init intl-tel-input ONLY for new section
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
    
        Object.entries(errorMap).forEach(([className, baseId]) => {
            $('.' + className).each(function(index) {
                $(this).attr('id', `${prefix}_${baseId}_${index}_error`);
            });
        });
    }
    
    // Add More Contact Person Ends --------------------------------------------
    
    
    
    
    
    
    
    // Same As GST Address Start -----------------------------------------------
    
    $(document).on("change", ".same-as-permanent-address", function () {

        const checked = $(this).is(":checked");
    
        // ===== PERMANENT =====
        const permanentAddress = $("#permanentAddr").val();
        const permanentState   = $("#permanentAddrState").val();
        const permanentCity    = $("#permanentAddrCity").val();
        const permanentPin     = $("#permanentAddrPostalCode").val();
        const permanentInfo    = $("#permanentAddrAdditionalInfo").val();
    
        // ===== PRESENT =====
        const $presentAddress = $("#presentAddr");
        const $presentState   = $("#presentAddrState");
        const $presentCity    = $("#presentAddrCity");
        const $presentPin     = $("#presentAddrPostalCode");
        const $presentInfo    = $("#presentAddrAdditionalInfo");
    
        if (checked) {
    
            // Copy simple fields
            $presentAddress.val(permanentAddress);
            $presentPin.val(permanentPin);
            $presentInfo.val(permanentInfo);
    
            // Set STATE (triggers city AJAX)
            $presentState.val(permanentState).trigger("change");
    
            // Wait for cities to load, then set CITY
            let waitForCity = setInterval(function () {
                if ($presentCity.find("option").length > 1) {
                    $presentCity.val(permanentCity).trigger("change");
                    clearInterval(waitForCity);
                }
            }, 150);
    
        } else {
    
            // Clear present address
            $presentAddress.val("");
            $presentPin.val("");
            $presentInfo.val("");
    
            $presentState.val("").trigger("change");
            $presentCity.val("").trigger("change");
        }
    });
    
    // Same As GST Address Ends ------------------------------------------------
    
    
    
    
    // Charge button toggle
    $('.dbtn-chargable').click(function(){
        $('.rate-wrap').toggle();
    });

    // Checkbox toggle for charge section
    $('.charge-checked').click(function(){
        $('.if-checked').toggle();
    });
    
    
    
    
    
    $('.dob').on('change blur', function () {
        let dob = $(this).val();
        let errorBox = $('#add_dob_error');

        errorBox.addClass('d-none').text('');

        if (!dob) {
            errorBox.text('Date of birth is required').removeClass('d-none');
            return false;
        }

        let dobDate = new Date(dob);
        let today = new Date();

        // Future date check
        if (dobDate > today) {
            errorBox.text('Date of birth cannot be a future date').removeClass('d-none');
            $(this).val('');
            return false;
        }

        // Age calculation
        let age = today.getFullYear() - dobDate.getFullYear();
        let monthDiff = today.getMonth() - dobDate.getMonth();
        
        $('#age').val(age);

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }

        // Minimum age validation
        if (age < 18) {
            errorBox.text('Age must be at least 18 years').removeClass('d-none');
            $(this).val('');
            return false;
        }
    });
    
    
    
    $('#doj').on('change', function () {

        let dojVal = $(this).val();
        if (!dojVal) {
            $('#associated_since').val('');
            return;
        }

        let doj = new Date(dojVal);
        let today = new Date();

        if (doj > today) {
            $('#add_doj_error').text('Date of joining cannot be future date');
            $(this).val('');
            $('#associated_since').val('');
            return;
        } else {
            $('#add_doj_error').text('');
        }

        let years = today.getFullYear() - doj.getFullYear();
        let months = today.getMonth() - doj.getMonth();
        let days = today.getDate() - doj.getDate();

        // Adjust days & months
        if (days < 0) {
            months--;
            let prevMonth = new Date(today.getFullYear(), today.getMonth(), 0);
            days += prevMonth.getDate();
        }

        if (months < 0) {
            years--;
            months += 12;
        }

        let result = years + " Years " + months + " Months " + days + " Days";

        $('#associated_since').val(result);
    });
    
    
    
    
    
    // =========================================================================
    function loadDependentDropdown({
        parentSelector,
        childSelector,
        urlTemplate,
        placeholder = 'Select Option',
        valueKey = 'id',
        textKey = 'name'
    }) {
        $(document).on('change', parentSelector, function () {
            let parentId = $(this).val();
    
            let $child = $(childSelector);
            $child.html(`<option value="">${placeholder}</option>`);
    
            if (!parentId) return;
    
            $.ajax({
                url: urlTemplate.replace('__ID__', parentId),
                type: 'GET',
                success: function (response) {
                    $.each(response, function (_, item) {
                        $child.append(
                            `<option value="${item[valueKey]}">${item[textKey]}</option>`
                        );
                    });
                }
            });
        });
    }
    
    loadDependentDropdown({
        parentSelector: '#office_department_id',
        childSelector: '#office_designation_id',
        urlTemplate: DESIGNATION_URL,
        placeholder: 'Select Designation'
    });
    
    loadDependentDropdown({
        parentSelector: '#service_center_department_id',
        childSelector: '#service_center_designation_id',
        urlTemplate: DESIGNATION_URL,
        placeholder: 'Select Designation'
    });
    
    loadDependentDropdown({
        parentSelector: '#servicecenter_technical_department_id',
        childSelector: '#servicecenter_technical_designation_id',
        urlTemplate: DESIGNATION_URL,
        placeholder: 'Select Designation'
    });
    
    
    
    // =========================================================================
    
    $(document).on('change', '.WorkTypeRadio', function () {
        if ($(this).val() === 'Office Work') {
            $('.office-work-wrap').show();
            $('.service-center-wrap').hide();
        } else if ($(this).val() === 'Service Center') {
            $('.service-center-wrap').show();
            $('.office-work-wrap').hide();
        }
    });
    
    
    
    /* Admin / Technical Toggle */
    $(document).on('change', '.servicetTypeRadio', function () {
        $('.admintech_wrapper').slideDown(); 
        if ($(this).val() === 'Administrative') {
            $('.SkillSetDiv').slideUp();
        } else {
            $('.SkillSetDiv').slideDown();
        }
    });

    // run on page load (important for edit form)
    $(document).ready(function () {
        if ($('.servicetTypeRadio:checked').val() === 'Administrative') {
            $('.admintech_wrapper').show();
        }
    });
    
    
    
    
    
    // Update contact Start ------------------------------------------------------
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
    
    
    $(document).on('click', '.delete-location', function () {
        var locationid = $(this).data('locationid');
    
        $.ajax({
            url: DELETE_LOCATION_URL,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                location_id: locationid
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    }).then(() => {
                        window.location.href = CONTACTS;
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed: ' + response.message
                    });
                }
            },
            error: function (xhr) {
                let msg = xhr.responseJSON?.message || 'Something went wrong';
                Toast.fire({
                    icon: 'error',
                    title: msg
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
    
    
    
    
    
    // Employee Asset Section Start --------------------------------------------
    $(document).on('change', '.asset_type_radio', function () {

        let assetType = $(this).val();
    
        // Reset dropdown
        $('#asset_id').html('<option value="">Loading...</option>').prop('disabled', true).trigger('change');
    
        $.ajax({
            url: TYPE_WISE_ASSETS,
            type: "GET",
            data: { asset_type: assetType },
            success: function (response) {
    
                let options = '<option value="">Select Asset</option>';
    
                if (response.status && response.data.length > 0) {
    
                    $.each(response.data, function (key, asset) {
                        options += `<option value="${asset.id}">${asset.name}</option>`;
                    });
    
                } else {
                    options += '<option value="">No Assets Found</option>';
                }
    
                $('#asset_id').html(options).prop('disabled', false).trigger('change');
            },
            error: function (xhr) {

                let message = 'Something went wrong. Please try again.';
    
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
    
                Toast.fire({
                    icon: 'error',
                    title: message
                });
    
                $('#asset_id').html('<option value="">Select Asset</option>').prop('disabled', false).trigger('change');
            }
        });
    
    });
    
    $(document).on('change', '#asset_id', function () {

        let assetId = $(this).val();
    
        // Clear fields if nothing selected
        if (!assetId) {
            $('#asset_name').val('');
            $('#asset_model').val('');
            $('#asset_make').val('');
            return;
        }
    
        let url = ASSET_DETAILS_URL.replace(':id', assetId);
    
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
    
                if (response.status) {
    
                    $('#asset_name').val(response.data.name);
                    $('#asset_model').val(response.data.model);
                    $('#asset_make').val(response.data.make);
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to fetch asset details'
                });
            }
        });
    
    });
    
    
    $(document).on('click','#addEmployeeAssetBtn',function(){ 
        $('form#addEmployeeAssetForm').submit();
    });
    
    $('form#addEmployeeAssetForm').on('submit', function(){ 

        // Step 1: Clear previous errors
        $('.error').html('');

        // Step 2: Disable submit button and show spinner
        $('#addEmployeeAssetBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

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
                $('#addEmployeeAssetBtn').html('Save').attr('disabled', false);
                if(response.success){
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#addEmployeeAssetBtn').html('Save').attr('disabled', false);
                    
                    // store tab
                    sessionStorage.setItem('activeTab', '#e-asset-attachments');
                    
                    location.reload(true);
                }
            },
            error: function(xhr){   
                $('#addEmployeeAssetBtn').html('Save').attr('disabled', false);
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
    
    
    
    $(document).on('click', '.revoke-btn', function () {

        var employeeAssetId = $(this).data('id');
        var assetName       = $(this).data('asset');
    
        $('#employeeasset_id').val(employeeAssetId);
        $('#emp_asset_name').val(assetName);
    
    });
    
    $(document).on('click','#addEmployeeAssetRevokeBtn',function(){ 
        $('form#addEmployeeAssetRevokeForm').submit();
    });
    
    $('form#addEmployeeAssetRevokeForm').on('submit', function(){ 

        // Step 1: Clear previous errors
        $('.error').html('');

        // Step 2: Disable submit button and show spinner
        $('#addEmployeeAssetRevokeBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

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
                $('#addEmployeeAssetRevokeBtn').html('Save').attr('disabled', false);
                if(response.success){
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#addEmployeeAssetRevokeBtn').html('Save').attr('disabled', false);
                    location.reload(true);
                }
            },
            error: function(xhr){   
                $('#addEmployeeAssetRevokeBtn').html('Save').attr('disabled', false);
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
    
    // Employee Asset Section Ends ---------------------------------------------
    
    
    
    // Employee Experience Details Section Start -------------------------------
    
    // $('.select2').select2({
    //     dropdownParent: $('#workExperienceModal'),
    //     width: '100%'
    // });
    
    $('#workExperienceModal .select2').select2({
        dropdownParent: $('#workExperienceModal'),
        width: '100%'
    });

    $(document).on('click', '.add-emp-experience', function () {
        var contactId = $(this).data('id');
        $('#experience_contact_id').val(contactId);
    });
    
    $(document).on('click','#addEmployeeWorkExperienceBtn',function(){ 
        $('form#addEmployeeWorkExperienceForm').submit();
    });
    
    $('form#addEmployeeWorkExperienceForm').on('submit', function(){ 

        // Step 1: Clear previous errors
        $('.error').html('');

        // Step 2: Disable submit button and show spinner
        $('#addEmployeeWorkExperienceBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

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
                $('#addEmployeeWorkExperienceBtn').html('Save').attr('disabled', false);
                if(response.success){
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#addEmployeeWorkExperienceBtn').html('Save').attr('disabled', false);
                    location.reload(true);
                }
            },
            error: function(xhr){   
                $('#addEmployeeWorkExperienceBtn').html('Save').attr('disabled', false);
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
    
    // Employee Experience Details Section Ends --------------------------------
    
    
    
    // Employee Salary Section Start -------------------------------------------
    $(document).on('click','#addEmployeeSalaryBtn',function(){ 
        $('form#addEmployeeSalaryForm').submit();
    });
    
    $('form#addEmployeeSalaryForm').on('submit', function(){ 

        // Step 1: Clear previous errors
        $('.error').html('');

        // Step 2: Disable submit button and show spinner
        $('#addEmployeeSalaryBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);

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
                $('#addEmployeeSalaryBtn').html('Save').attr('disabled', false);
                if(response.success){
                    Toast.fire({ icon: 'success', title: response.message });
                    $('#addEmployeeSalaryBtn').html('Save').attr('disabled', false);
                    
                    // store tab
                    sessionStorage.setItem('activeTab', '#e-salary-attachments');
                    
                    location.reload(true);
                }
            },
            error: function(xhr){   
                $('#addEmployeeSalaryBtn').html('Save').attr('disabled', false);
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
    // Employee Salary Section Ends --------------------------------------------
    
    
    
    // Employee Exit Detail Section Start --------------------------------------
    $(document).on('click', '#exitDetailBtn', function (e) {

        e.preventDefault();
    
        let contactId = $("#edit_contactid_input").val();
    
        $('.error').text('');
    
        $('#exitDetailBtn').prop('disabled', true);
    
        $.ajax({
            url: EXIT_DETAIL_URL,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                contact_id: contactId,
                exit_reason: $('#exit_reason').val(),
                exit_date: $('#exit_date').val(),
                exit_feedback: $('#exit_feedback').val()
            },
    
            success: function (response) {
    
                if (response.success) {
    
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    
                    // store tab
                    sessionStorage.setItem('activeTab', '#exit');
    
                    location.reload();
    
                } else {
    
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
    
                $('#exitDetailBtn').prop('disabled', false);
            },
    
            error: function (xhr) {  console.log(xhr.responseJSON.errors);
    
                if (xhr.status === 422) {
    
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('#edit_' + key + '_error').text(value[0]);
                    });
    
                }
    
                $('#exitDetailBtn').prop('disabled', false);
            }
        });
    
    });
    
    
    /*$(document).on('click', '#exitDetailBtn', function (e) {
        //console.log('Button clicked');
        let contactId = $("#edit_contactid_input").val();
        let exit_reason = $('#exit_reason').val();
        let exit_date = $('#exit_date').val();
        let exit_feedback = $('#exit_feedback').val();
        
        // Clear old errors
        $('#add_exit_reason_error').text('');
        $('#add_exit_date_error').text('');
        $('#add_exit_feedback_error').text('');
        
        // Frontend validation
        if (!exit_reason) {
            $('#add_exit_reason_error').text('This field is required.');
            return false;
        }
    
        if (!exit_date) {
            $('#add_exit_date_error').text('This field is required.');
            return false;
        }
    
        if (!exit_feedback) {
            $('#add_exit_feedback_error').text('This field is required.');
            return false;
        }
        
        $('#exitDetailBtn').prop('disabled', true);
        
        $.ajax({
            url: EXIT_DETAIL_URL, // define route in blade
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                contact_id: contactId,
                exit_reason: exit_reason,
                exit_date: exit_date,
                feedback: exit_feedback
            },
            success: function (response) {
    
                if (response.success) {
    
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
    
                    // Reset fields
                    $('#exit_reason').val('');
                    $('#exit_date').val('');
                    $('#exit_feedback').val('');
    
                    location.reload(true);
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
    
                $('#exitDetailBtn').prop('disabled', false);
            },
            error: function (xhr) {
    
                console.log("Status:", xhr.status);
                console.log("Response:", xhr.responseText);
    
                if (xhr.status === 419) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Session expired. Please refresh the page.'
                    });
                }
    
                if (xhr.responseJSON?.errors) {
    
                    let errors = xhr.responseJSON.errors;
    
                    if (errors.exit_reason) {
                        $('#add_exit_reason_error').text(errors.exit_reason[0]);
                    }
    
                    if (errors.exit_date) {
                        $('#add_exit_date_error').text(errors.exit_date[0]);
                    }
    
                    if (errors.feedback) {
                        $('#add_exit_feedback_error').text(errors.feedback[0]);
                    }
                }
    
                $('#exitDetailBtn').prop('disabled', false);
            }
        });
        
    });*/
    // Employee Exit Detail Section Ends ---------------------------------------
    
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).on('click', '.updateLetterSeenStatus', function (e) {

        e.preventDefault();
    
        let url = $(this).attr('href');
        let contactId = $(this).data('id');
        let type = $(this).data('type');
    
        // Open new tab immediately (no popup blocker issue)
        let newTab = window.open(url, '_blank');
        
        
        $.ajax({
            url: LETTER_SEEN_URL,
            type: "POST",
            data: {
                contact_id: contactId,
                type: type,
                seen_status: 'Yes'
            },
            success: function (response) {
                console.log('Seen status updated');
            },
            error: function (xhr) {
                console.log('Status Code:', xhr.status);
                console.log('Response:', xhr.responseText);
            }
        });
    
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});








