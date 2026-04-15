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
        url: '/upload/images',
        paramName: "file",
        maxFiles: 2,
        maxFilesize: 2,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        dictRemoveFile: "✖",
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

document.addEventListener("DOMContentLoaded", function () {
    
    const yesRadio = document.getElementById("legalcase_yes");
    const noRadio = document.getElementById("legalcase_no");
    const caseBox = document.querySelector(".opencase_01desc");

    yesRadio.addEventListener("change", function () {
        if (this.checked) {
            caseBox.style.display = "block";
        }
    });

    noRadio.addEventListener("change", function () {
        if (this.checked) {
            caseBox.style.display = "none";
        }
    });
    
    // new Choices('#multiSelect', {
    //     removeItemButton: true,
    // });
        
        
        
        

    /* =========================
     Provident Fund Toggle
     ========================= */
    document.querySelectorAll('input[name="providentFund"]').forEach((radio) => {
        radio.addEventListener("change", function () {
            const pfField = document.getElementById("pf_number_field");
            pfField.style.display = (this.value === "yes") ? "flex" : "none";
        });
    });

    
});


/* =========================
   Image Upload (jQuery)
   ========================= */
ImgUpload();

function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var filesArr = Array.prototype.slice.call(e.target.files);

      filesArr.forEach(function (f) {
        if (!f.type.match('image.*')) return;
        if (imgArray.length >= maxLength) return;

        imgArray.push(f);

        var reader = new FileReader();
        reader.onload = function (e) {
          var html =
            "<div class='upload__img-box'>" +
              "<div style='background-image: url(" + e.target.result + ")' " +
              "data-file='" + f.name + "' class='img-bg'>" +
                "<div class='upload__img-close'></div>" +
              "</div>" +
            "</div>";
          imgWrap.append(html);
        };
        reader.readAsDataURL(f);
      });
    });
  });

  $('body').on('click', '.upload__img-close', function () {
    var file = $(this).parent().data('file');
    imgArray = imgArray.filter(img => img.name !== file);
    $(this).closest('.upload__img-box').remove();
  });
}

$('#assettypeModal').on('shown.bs.modal', function () {
    $(this).find('.select2').select2({
        dropdownParent: $('#assettypeModal'),
        width: '100%'
    });
});


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
    
    // Person add/remove
    $('.add-person').click(function(){
        $('.added-person').show();
    });

    $('#filebtn').click(function(){
        $('#fileInput').click();
    });

    $('.close-sec').click(function(){
        $('.added-person').hide();
    });

    // Address add/remove
    $('.add-address').click(function(){
        $('.added-sec').show();
    });

    $('.close-address').click(function(){
        $('.added-sec').hide();
    });

    // Checkbox add/remove class
    $('.clickto-adclass').change(function(){
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').addClass('active');
        } else {
            $('.days-beforeexpiry').removeClass('active');
        }
    });
    
    
    
    
    
    
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
                    $newSection.find('.select2').select2();
            
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
    
    
    
    // loadDependentDropdown({
    //     parentSelector: '#country_id',
    //     childSelector: '#state_id',
    //     urlTemplate: STATE_URL,
    //     placeholder: 'Select State'
    // });
    
    // loadDependentDropdown({
    //     parentSelector: '#state_id',
    //     childSelector: '#city_id',
    //     urlTemplate: CITY_URL,
    //     placeholder: 'Select City'
    // });

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
    

    
    
    
    // Save contact Start ------------------------------------------------------
    $(document).on("click","#addContactBtn", function(){
        $('form#addContactForm').submit();
    });
    
    $('form#addContactForm').on("submit",function(){
        
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
            dataType    : 'application/json',
            success     : function(response){
                if (response.success === true) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
        
                    $('#addContactBtn').html('Save').attr('disabled', false);
        
                    // redirect after short delay (optional)
                    setTimeout(function(){
                        window.location.href = CONTACTS;
                    }, 1000);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                    $('#addContactBtn').html('Save').attr('disabled', false);
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