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
    
    
    
    
    
    $(document).on('click','#editBtn',function(){
        $('form#editForm').submit();
    });
    
    $('form#editForm').on('submit', function(){
        var formData = new FormData(this);
        // Ensure hidden field is included
        formData.append('jobrankid', $('#edit_jobrankid_input').val());
    
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
                window.location.href = JOBRANKS;
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
                    $(`#edit_${field}_error`).text(messages[0]);
                });
            }
        });
    
        return false;
    });

    
    
    
    
    


});





