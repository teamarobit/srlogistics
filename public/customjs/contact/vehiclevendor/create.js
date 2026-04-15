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
    formData.append('form_type', 'Add');

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
    
    $('.table .form-control').each(function(index, value) {
        if($(this).val().length){
            $(this).addClass('has-val');
        }
    });
    
    $('.select2').select2();
    
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
    
    
    
    
    $(document).on('click', '.contact-status', function () {
        if ($(this).val() === 'Blacklisted') {
            $('.statusblacklist').show();
        } else {
            $('.statusblacklist').hide();
        }
    });
    
    
    
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
    
    
    
    
    
    
    // Add More Bank Detail Start ----------------------------------------------
    
    var bank_rowindex = 0;
    
    $(document).on('click', '.add-bank', function (e) {
        e.preventDefault();
    
        bank_rowindex++;
    
        var formData = new FormData();
        formData.append('rowindex', bank_rowindex);
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: BANK_WRAPPER,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
    
            success: function (response) {
                console.log('res:-', response);
                
                if (response.success) {

                    const $newSection = $(response.data);
                    $('#bankDetailsContainer').append($newSection);
                
                    assignBankErrorIds(); 
                
                }
    
            }
        });
    });
    
    
    function assignBankErrorIds(prefix = "add") {

        const errorMap = {
            b_primary_err: 'is_primary',
            b_id_err:   'bank_id',
            b_name_err:    'beneficiary_name',
            b_accno_err:      'account_number',
            b_ifsc_err:     'ifsc_code',
            b_upi_err:     'upi_id'
        };
    
        $('.bank-data').each(function () {
    
            let rowIndex = $(this).data('index'); // use actual row index
    
            Object.entries(errorMap).forEach(([className, baseId]) => {
    
                $(this).find('.' + className).attr(
                    'id',
                    `${prefix}_${baseId}_${rowIndex}_error`
                );
    
            });
    
        });
    }
    
    $(document).on('click', '.close-bank', function (e) {
        e.preventDefault();
    
        //if ($('.bank-data').length > 1) {
            $(this).closest('.bank-data').remove();
        //}
    });
    
    $(document).on('change', '.bank-status[value="Yes"]', function () {
        if ($(this).is(':checked')) {
            $('.bank-status[value="Yes"]').not(this).prop('checked', false);
        }
    });
    
    // Add More Bank Detail Ends -----------------------------------------------
    
    
    
    
    
    
    
    
    // Charge button toggle
    $('.dbtn-chargable').click(function(){
        $('.rate-wrap').toggle();
    });

    // Checkbox toggle for charge section
    $('.charge-checked').click(function(){
        $('.if-checked').toggle();
    });
    
    
    
    // Save contact Start ------------------------------------------------------
    $(document).on("click","#addContactBtn", function(){
        $('form#addContactForm').submit();
    });
    
    $('form#addContactForm').on("submit",function(e){
        
        e.preventDefault();
        
        $button = $('#addContactBtn');
        
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
            success: function(response){

                if(response.success === true){
    
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                        didClose: () => {
                            window.location.href = CONTACTS;
                        }
                    });
    
                } else {
    
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
    
                }
    
                $button.html('Save').attr('disabled', false);
            },
            error       : function(data){
                
                var response = $.parseJSON(data.responseText);
                if(response.success === true){
                    
                    Toast.fire({
                      icon: 'success',
                      title: response.message,
                      didClose: () => {
                          window.location.href = CONTACTS
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
                                    $('#add_' + index.split('.').splice(0,2).join('_') + '_error').text(
                                      value.join('').replace(index, index.split('.').splice(0,2).join('_'))
                                    );
                              }else if(index.split('.').length === 2) {
                                    $('#add_' + index.split('.').join('_') + '_error').text(value);
                              }
                          } else {
                                 $('#add_'+index+'_error').text(value);
                          }
                    });
                    
                    $button.html('Save').attr('disabled', false);
                    
                }
            }

        });
        
        return false;
    });
    // Save contact Ends -------------------------------------------------------
    
    
    
    
    
});