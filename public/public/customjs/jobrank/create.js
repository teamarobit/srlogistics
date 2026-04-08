
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
        parentSelector: '#department_id',
        childSelector: '#designation_id',
        urlTemplate: DESIGNATION_URL,
        placeholder: 'Select Designation'
    });
    
    
    
    $(document).on('click', '#addBtn', function () {
        $('form#addForm').submit();
    });

    $('form#addForm').on('submit', function () {
        var formData = new FormData(this);
    
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    
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
                window.location.href = JOBRANKS;
            },
    
            error: function (xhr) {
                $('#addBtn').html('Save').attr('disabled', false);
            
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
                    // $(`#add_${field}_error`).text('');
            
                    if ($input.length) {
            
                        // If radio or checkbox group
                        if ($input.attr('type') === 'radio' || $input.attr('type') === 'checkbox') {
            
                            // Add invalid styling if needed
                            $input.addClass('is-invalid');
            
                            // Put the message into your existing small.error span
                            $(`#add_${field}_error`).text(messages[0]);
            
                        } else {
                            // Normal inputs
            
                            $input.addClass('is-invalid');
            
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







