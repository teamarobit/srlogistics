
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
    
    
    // Image upload
    ImgUpload();
    
    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];
    
        $('.upload__inputfile').each(function () {
            $(this).on('change', function (e) {
                imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                var maxLength = $(this).attr('data-max_length');
    
                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
    
                filesArr.forEach(function (f) {
    
                    if (!f.type.match('image.*')) return;
    
                    if (imgArray.length >= maxLength) return;
    
                    imgArray.push(f);
    
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var html = `
                            <div class="upload__img-box">
                                <div class="img-bg" 
                                     style="background-image:url(${e.target.result})"
                                     data-file="${f.name}">
                                    <div class="upload__img-close"></div>
                                </div>
                            </div>`;
                        imgWrap.append(html);
                    };
                    reader.readAsDataURL(f);
                });
            });
        });
    
        $('body').on('click', '.upload__img-close', function () {
            var file = $(this).parent().data('file');
    
            imgArray = imgArray.filter(function (img) {
                return img.name !== file;
            });
    
            $(this).closest('.upload__img-box').remove();
        });
    }
    
    
    

    
    // Initial visibility
    $(".motor_vehicle").show();
    $(".MotorVehicleNumber").show(); 
    $(".MotorVehicleAge").show();
    $(".ElectronicsDiv").hide();
    $(".AssetTypeName").hide();

    // Radio change handler
    $(".status-radio").on("change", function () {
        let value = $(this).val();
    
        // Hide all first
        $(".MotorVehicleNumber, .MakeDiv, .ModelDiv, .MotorVehicleNumberRCDate, .MotorVehicleAge, .ElectronicsDiv, .AssetTypeName, .IssueDateDiv, .AssignedOnDiv, .AssignedByDiv, .WarrantyStartDiv, .WarrantyEndDiv, .AgeDiv").hide();
    
        if (value === "Motor Vehicle") {
            $(".MotorVehicleNumber, .MakeDiv, .ModelDiv, .MotorVehicleNumberRCDate, .MotorVehicleAge, .IssueDateDiv, .AssignedOnDiv, .AssignedByDiv").show();
        } else if (value === "Others") {
            $(".AssetTypeName, .ElectronicsDiv, .WarrantyStartDiv, .WarrantyEndDiv").show();
        } else {
            $(".MakeDiv, .ModelDiv, .ElectronicsDiv, .IssueDateDiv, .AssignedOnDiv, .AssignedByDiv, .WarrantyStartDiv, .WarrantyEndDiv, .AgeDiv").show();
        }
    });


    
    
    
    $(document).on('click', '#addBtn', function () {
        $('form#addForm').submit();
    });

    $('form#addForm').on('submit', function () {
        var formData = new FormData(this);
    
        // Clear previous errors
        // $('.is-invalid').removeClass('is-invalid');
        // $('.invalid-feedback').remove();
        
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
                window.location.href = ASSETS;
            },
    
            error: function (xhr) {
                $('#addBtn').html('Save').attr('disabled', false);
            
                let response = $.parseJSON(xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation error.'
                });
            
                let errors = response.data || {};
                Object.entries(errors).forEach(([field, messages]) => {
                    
                    // HANDLE ARRAY FIELDS (documents.0, quantity.0 etc.)
                    if (field.includes('.')) {
                        let baseField = field.split('.')[0]; // documents.0 → documents
                        $(`#add_${baseField}_error`).text(messages[0]);
                        return;
                    }
                
            
                    const nameAttr = field.replace(/\.(\d+)/g, '[$1]'); // quantity.0 → quantity[0]
                    const $input = $(`[name="${nameAttr}"]`);
            
                    // Clear any previous small.error for this field first, if you prefer:
                    // $(`#add_${field}_error`).text('');
            
                    if ($input.length) {
            
                        // If radio or checkbox group
                        if ($input.attr('type') === 'radio' || $input.attr('type') === 'checkbox') {
            
                            // Add invalid styling if needed
                            //$input.addClass('is-invalid');
            
                            // Put the message into your existing small.error span
                            $(`#add_${field}_error`).text(messages[0]);
            
                        } else {
                            // Normal inputs
            
                            //$input.addClass('is-invalid');
            
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







