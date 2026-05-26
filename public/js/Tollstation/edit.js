$(document).ready(function() {

    // BUG-011 fix: SD-1 — no inline JS in blade. Read constants from form data attrs.
    var TOLLSTATIONS = $('form#editForm').data('tollstation-list-url') || '/tollstations';

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
    
    
    
    
    
    
    // BUG-009 fix: numeric-only guard on charge fields (.decimalonly).
    $(document).on('input', '.decimalonly', function () {
        var v = $(this).val();
        v = v.replace(/[^0-9.]/g, '');
        var firstDot = v.indexOf('.');
        if (firstDot !== -1) {
            v = v.slice(0, firstDot + 1) + v.slice(firstDot + 1).replace(/\./g, '');
        }
        $(this).val(v);
    });


    // BUG-005 fix: clear stale "This field is required." messages
    // as soon as the field becomes valid.
    function clearErrorFor(name) {
        var key = name.replace(/\[(\d+)\]/g, '.$1');
        $('#edit_' + key + '_error').text('');
    }

    $(document).on('input change', 'form#editForm input, form#editForm textarea, form#editForm select', function () {
        var $el  = $(this);
        var name = $el.attr('name');
        if (!name) return;

        var val = $el.is(':radio') || $el.is(':checkbox')
            ? $('form#editForm [name="' + name + '"]:checked').val()
            : $el.val();

        if (val !== undefined && val !== null && String(val).trim() !== '') {
            clearErrorFor(name);
        }
    });

    $(document).on('click','#editBtn',function(e){
        e.preventDefault();
        $('form#editForm').trigger('submit');
    });

    $('form#editForm').on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);
        // Ensure hidden field is included
        formData.append('tollstationid', $('#edit_tollstationid_input').val());
    
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
                window.location.href = TOLLSTATIONS;
            },
            error: function(xhr){
                $('#editBtn').html('Save').attr('disabled', false);
                
                var response = $.parseJSON(xhr.responseText);
                
                Toast.fire({
                    icon: 'error',
                    title: response.message || 'Please check validation error.'
                });
    
                const errors = response.data || {};
                Object.entries(errors).forEach(([field, messages]) => {

                    // handle array fields (example: field.0 → field[0])
                    const nameAttr = field.replace(/\.(\d+)/g, '[$1]');
                    const $input = $(`[name="${nameAttr}"]`);
    
                    // ONLY show error text (NO red border)
                    if ($input.length) {
                        $(`#edit_${field}_error`).text(messages[0]);
                    } else {
                        $(`#edit_${field}_error`).text(messages[0]);
                    }
    
                });
            
            }
        });
    
        return false;
    });

    
    
    
    
    


});





