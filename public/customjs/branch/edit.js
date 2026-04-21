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

let dt = new DataTransfer();   // Holds selected files

// =============================
// NEW FILE SELECTION
// =============================
$("#branch_documents").on("change", function () {

    let files = this.files;

    for (let i = 0; i < files.length; i++) {
        dt.items.add(files[i]);
    }

    this.files = dt.files;
    renderPreview();
});

// =============================
// RENDER NEW FILE PREVIEW
// =============================
function renderPreview() {

    const preview = $("#previewContainer");
    preview.html("");

    Array.from(dt.files).forEach((file, index) => {

        let content = "";

        // IMAGE THUMBNAIL
        if (file.type.startsWith("image/")) {

            const reader = new FileReader();

            reader.onload = function(e) {
                addBlock(e.target.result, file.name, index, true);
            };

            reader.readAsDataURL(file);
        }
        else {
            addBlock(null, file.name, index, false);
        }
    });
}


// =============================
// ADD NEW FILE BLOCK
// =============================
function addBlock(imgSrc, name, index, isImage) {

    let html = `
        <div style="position:relative;border:1px solid #ddd;padding:5px;">
            
            ${isImage 
                ? `<img src="${imgSrc}" style="width:80px;height:80px;object-fit:cover;">`
                : `<div style="width:80px;height:80px;display:flex;align-items:center;justify-content:center;font-size:12px;">ðŸ“„</div>`
            }

            <div style="font-size:11px;width:80px;overflow:hidden;">${name}</div>
            
            <button type="button" onclick="removeFile(${index})" class="remove-file-btn">
                <i class="fa fa-times"></i>
            </button>
        </div>
    `;

    $("#previewContainer").append(html);
}


// =============================
// REMOVE NEW FILE
// =============================
function removeFile(index) {

    dt.items.remove(index);

    document.getElementById("branch_documents").files = dt.files;

    renderPreview();
}


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



$('document').ready(function(){
    $('.if-rental').click(function(){
        $('.rental-wrap').show();
        $('.own-wrap').hide();
    })
    $('.if-owned').click(function(){
        $('.rental-wrap').hide();
        $('.own-wrap').show();
    })
});


$(document).ready(function() {
    
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
                error: function () {
                    $target.html('<option value="">Error loading cities</option>');
                }
            });
        });
    }
    
    
    
    
    
    
    $(document).on('click','#editBtn',function(){
        $('form#editForm').submit();
    });
    
    $('form#editForm').on('submit', function(){
        $('.error_msg').html('');
        var formData = new FormData(this);
        // Ensure hidden field is included
        formData.append('branchid', $('#edit_branchid_input').val());
    
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
                window.location.href = BRANCHES;
            },
            error: function (xhr) {
                $('#editBtn').html('Save').attr('disabled', false);
            
                var response = $.parseJSON(xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation error.'
                });
            
                const errors = response.data || {};
                Object.entries(errors).forEach(([field, messages]) => {
            
                    const nameAttr = field.replace(/\.(\d+)/g, '[$1]'); // quantity.0 → quantity[0]
                    const $input = $(`[name="${nameAttr}"]`);
            
                    // Clear any previous small.error for this field first, if you prefer:
                    // $(`#edit_${field}_error`).text('');
            
                    if ($input.length) {
                        $(`#edit_${field}_error`).text(messages[0]);
                        // // If radio or checkbox group
                        // if ($input.attr('type') === 'radio' || $input.attr('type') === 'checkbox') {
            
                        //     // Add invalid styling if needed
                        //     $input.addClass('is-invalid');
            
                        //     // Put the message into your existing small.error span
                        //     $(`#edit_${field}_error`).text(messages[0]);
            
                        // } else {
                        //     // Normal inputs
            
                        //     $input.addClass('is-invalid');
            
                        //     // Try to find existing small.error span
                        //     let $small = $(`#edit_${field}_error`);
            
                        //     if ($small.length) {
                        //         // set text
                        //         $small.text(messages[0]);
                        //     } else {
                        //         // fallback: create the small.error right after the input
                        //         $input.after(
                        //             `<small class="error text-danger" id="edit_${field}_error">${messages[0]}</small>`
                        //         );
                        //     }
                        // }
            
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





