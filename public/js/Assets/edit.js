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
    
    
    // Single-date pickers (daterangepicker, DD-MM-YYYY display) — preload existing value
    function singleDate(sel, opts) {
        var $el = $(sel);
        if (!$el.length) return;
        $el.daterangepicker($.extend({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            locale: { format: 'DD-MM-YYYY', cancelLabel: 'Clear' }
        }, opts || {}));
        var existing = $el.val();
        if (existing) {
            var m = moment(existing, 'DD-MM-YYYY', true);
            if (m.isValid()) {
                $el.data('daterangepicker').setStartDate(m);
                $el.data('daterangepicker').setEndDate(m);
            }
        }
        $el.on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });
        $el.on('cancel.daterangepicker', function () {
            $(this).val('');
        });
    }

    singleDate('#edit_purchase_date',      { maxDate: moment() }); // block future
    singleDate('#edit_rc_date',            { maxDate: moment() }); // block future
    singleDate('#edit_warranty_start_date');
    singleDate('#edit_warranty_end_date');
    singleDate('#edit_issue_date',         { minDate: moment() }); // block past

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
        $(".MotorVehicleNumber, .MakeDiv, .ModelDiv, .MotorVehicleNumberRCDate, .MotorVehicleAge, .ElectronicsDiv, .AssetTypeName, .IssueDateDiv, .WarrantyStartDiv, .WarrantyEndDiv, .AgeDiv").hide();
    
        if (type === "Motor Vehicle") {
    
            $(".motor_vehicle").css("display", "block");
    
            $(".MotorVehicleNumber, .MakeDiv, .ModelDiv, .MotorVehicleNumberRCDate, .MotorVehicleAge, .IssueDateDiv").show();
    
        } 
        else if (type === "Electronics") {
    
            $(".motor_vehicle").css("display", "block");
    
            $(".MakeDiv, .ModelDiv, .ElectronicsDiv, .IssueDateDiv, .WarrantyStartDiv, .WarrantyEndDiv, .AgeDiv").show();
    
        } 
        else if (type === "Others") {
            $(".motor_vehicle").css("display", "block");
            $(".AssetTypeName, .ElectronicsDiv, .WarrantyStartDiv, .WarrantyEndDiv").show();
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

    $('form#editForm').on('submit', function(e){

        e.preventDefault();

        var form = $(this);

        // Issue 19 — block oversized files client-side with a clear message
        var tooBig = oversizedFiles(this);
        if (tooBig.length) {
            $('#edit_documents_error').text('Each file must be ' + MAX_UPLOAD_MB + ' MB or less. Too large: ' + tooBig.join(', '));
            Toast.fire({ icon: 'error', title: 'File too large (max ' + MAX_UPLOAD_MB + ' MB).' });
            return false;
        }

        var assetId = form.find('[name="assetid"]').val();

        console.log('Sending assetid:', assetId);

        var formData = new FormData(this);
        formData.set('assetid', assetId);

        // Convert displayed DD-MM-YYYY dates to Y-m-d for backend validation
        ['purchase_date', 'rc_date', 'warranty_start_date', 'warranty_end_date', 'issue_date'].forEach(function (n) {
            var v = $('[name="' + n + '"]').val();
            if (v) { formData.set(n, moment(v, 'DD-MM-YYYY').format('YYYY-MM-DD')); }
        });

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

                            // Put the message into your existing small.error span
                            $(`#edit_${field}_error`).text(messages[0]);

                        } else {
                            // Normal inputs

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





