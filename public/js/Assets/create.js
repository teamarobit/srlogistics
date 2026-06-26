
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

        $('.upload__inputfile').each(function () {

            var input     = this;
            var dt        = new DataTransfer();              // canonical file list for this input
            var $imgWrap  = $(input).closest('.upload__box').find('.upload__img-wrap');
            var maxLength = parseInt($(input).attr('data-max_length'), 10) || 20;

            function fileKey(f) {
                return f.name + '|' + f.size + '|' + f.lastModified;
            }

            $(input).on('change', function (e) {

                Array.prototype.slice.call(e.target.files).forEach(function (f) {

                    if (dt.files.length >= maxLength) return;     // respect max

                    // skip files already added
                    var exists = Array.prototype.some.call(dt.files, function (g) {
                        return fileKey(g) === fileKey(f);
                    });
                    if (exists) return;

                    dt.items.add(f);                              // keep every accepted file

                    var key = fileKey(f);
                    if (f.type.match('image.*')) {
                        var reader = new FileReader();
                        reader.onload = function (ev) {
                            $imgWrap.append(`
                                <div class="upload__img-box" data-filekey="${key}">
                                    <div class="img-bg" style="background-image:url(${ev.target.result})" data-file="${f.name}">
                                        <div class="upload__img-close"></div>
                                    </div>
                                </div>`);
                        };
                        reader.readAsDataURL(f);
                    } else {
                        // non-image accepted file (e.g. pdf) — show filename box (existing classes only)
                        $imgWrap.append(`
                            <div class="upload__img-box" data-filekey="${key}">
                                <div class="img-bg" data-file="${f.name}">${f.name}
                                    <div class="upload__img-close"></div>
                                </div>
                            </div>`);
                    }
                });

                input.files = dt.files;                          // sync accumulated list back to the input
            });

            // remove one newly-added file from both preview and the input
            $imgWrap.on('click', '.upload__img-close', function () {
                if ($(this).hasClass('remove-existing-btn')) return;   // existing files handled elsewhere

                var key  = String($(this).closest('.upload__img-box').data('filekey'));
                var kept = new DataTransfer();
                Array.prototype.forEach.call(dt.files, function (g) {
                    if (fileKey(g) !== key) kept.items.add(g);
                });
                dt = kept;
                input.files = dt.files;
                $(this).closest('.upload__img-box').remove();
            });
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

    // Issue 19 — keep in sync with documents.* max:10240 (KB) in AssetController
    var MAX_UPLOAD_MB = 10;
    function oversizedFiles(form) {
        var bad = [];
        $(form).find('input[type="file"]').each(function () {
            Array.prototype.forEach.call(this.files || [], function (f) {
                if (f.size > MAX_UPLOAD_MB * 1024 * 1024) bad.push(f.name);
            });
        });
        return bad;
    }

    $('form#addForm').on('submit', function () {

        // Issue 19 — block oversized files client-side with a clear message
        var tooBig = oversizedFiles(this);
        if (tooBig.length) {
            $('#add_documents_error').text('Each file must be ' + MAX_UPLOAD_MB + ' MB or less. Too large: ' + tooBig.join(', '));
            Toast.fire({ icon: 'error', title: 'File too large (max ' + MAX_UPLOAD_MB + ' MB).' });
            return false;
        }

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







