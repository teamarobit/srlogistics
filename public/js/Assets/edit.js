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
    
    
    
    $('body').on('click', '.remove-existing-btn', function () {

        var fileId = $(this).data('id');
    
        // mark for delete
        $('<input>').attr({
            type: 'hidden',
            name: 'remove_files[]',
            value: fileId
        }).appendTo('#editForm');
    
        // remove preview
        $(this).closest('.upload__img-box').remove();
    });
    
    

    
    
    // Toggle function (COMMON for Add + Edit)
    function toggleFields(type) { 
    
        // Hide all first
        $(".motor_vehicle").hide();
        $(".MotorVehicleNumber, .MakeDiv, .ModelDiv, .MotorVehicleNumberRCDate, .MotorVehicleAge, .ElectronicsDiv, .AssetTypeName, .IssueDateDiv, .AssignedOnDiv, .AssignedByDiv, .WarrantyStartDiv, .WarrantyEndDiv, .AgeDiv").hide();
    
        if (type === "Motor Vehicle") {
    
            $(".motor_vehicle").show();
    
            $(".MotorVehicleNumber, .MakeDiv, .ModelDiv, .MotorVehicleNumberRCDate, .MotorVehicleAge, .IssueDateDiv, .AssignedOnDiv, .AssignedByDiv").show();
    
        } 
        else if (type === "Electronics") {
    
            $(".motor_vehicle").show();
    
            $(".MakeDiv, .ModelDiv, .ElectronicsDiv, .IssueDateDiv, .AssignedOnDiv, .AssignedByDiv, .WarrantyStartDiv, .WarrantyEndDiv, .AgeDiv").show();
    
        } 
        else if (type === "Others") {
            $(".motor_vehicle").show();
            $(".AssetTypeName").show();
        }
    }


    // Clear hidden fields (VERY IMPORTANT)
    function clearHiddenFields() {
        // $(':input').each(function () {
    
        //     // DO NOT touch hidden fields
        //     if ($(this).attr('type') === 'hidden') return;
    
        //     if (!$(this).closest('.form-group').is(':visible')) {
        //         $(this).val('');
        //     }
        // });
    }


    // Page Load (Edit + Add both)
    $(document).ready(function () {
    
        let selected = $('input[name="asset_type"]:checked').val();
    
        toggleFields(selected);
        clearHiddenFields();
    
        // On change
        $('input[name="asset_type"]').on('change', function () {
    
            let type = $(this).val();
    
            toggleFields(type);
            clearHiddenFields();
    
        });
    
    });


    
    // =============================
    // DELETE EXISTING FILE
    // =============================
    $(document).on("click", ".remove-existing-btn", function () {
    
        let box = $(this).closest(".file-box");
    
        let fileId = box.data("id");
    
        // Put ID inside hidden input
        box.find(".remove-input").val(fileId);
    
        // Hide from UI
        box.hide();
    });
    
    
    
    
    // CSRF setup (ONCE)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click','#editBtn',function(){
        $('form#editForm').submit();
    });
    
    $('form#editForm').on('submit', function(e){
        
        e.preventDefault();

        var form = $(this);
    
        var assetId = form.find('[name="assetid"]').val();
    
        console.log('Sending assetid:', assetId);
    
        var formData = new FormData(this);
        formData.set('assetid', assetId);
        
        
    
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
                window.location.href = ASSETS;
            },
            error: function (xhr) {
                $('#editBtn').html('Save').attr('disabled', false);
            
                //var response = $.parseJSON(xhr.responseText);
                let response = xhr.responseJSON || {};
                
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation error.'
                });
            
                let errors = response.data || {};
                Object.entries(errors).forEach(([field, messages]) => {
                    
                    // HANDLE ARRAY FIELDS (documents.0 etc.)
                    if (field.includes('.')) {
                        let baseField = field.split('.')[0];
                        $('#edit_' + baseField + '_error').text(messages[0]);
                        return;
                    }
            
                    const nameAttr = field.replace(/\.(\d+)/g, '[$1]'); // quantity.0 → quantity[0]
                    const $input = $(`[name="${nameAttr}"]`);
            
                    // Clear any previous small.error for this field first, if you prefer:
                    // $(`#edit_${field}_error`).text('');
            
                    if ($input.length) {
            
                        // If radio or checkbox group
                        if ($input.attr('type') === 'radio' || $input.attr('type') === 'checkbox') {
            
                            // Add invalid styling if needed
                            $input.addClass('is-invalid');
            
                            // Put the message into your existing small.error span
                            $(`#edit_${field}_error`).text(messages[0]);
            
                        } else {
                            // Normal inputs
            
                            $input.addClass('is-invalid');
            
                            // Try to find existing small.error span
                            let $small = $(`#edit_${field}_error`);
            
                            if ($small.length) {
                                // set text
                                $small.text(messages[0]);
                            } else {
                                // fallback: create the small.error right after the input
                                $input.after(
                                    `<small class="error text-danger" id="edit_${field}_error">${messages[0]}</small>`
                                );
                            }
                        }
            
                    } else {
                        // Fallback if input not found
                        $(`#edit_${field}_error`).text(messages[0]);
                    }
            
                });
            }
        });
    
        return false;
    });

    
    
    
    
    


});





