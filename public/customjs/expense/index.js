$(document).ready(function(){
    
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
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    
    $('#search_name, #search_status').on('change blur', function () { 
        $('#searchform').submit();
    });
    
    
    $(document).on('click','#addBtn',function(){
        $('form#addForm').submit();
    });
    $('form#addForm').on('submit', function(){
        var formData = new FormData(this);
        $('.error').html('');
        $('#addBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'application/json',
            success     : function(response){
                Toast.fire({
                    icon: 'success',
                    title: response.message || 'Saved successfully!'
                });
                $('#addBtn').html('Save').attr('disabled', false);
                window.location.href = LISTING;
            },
            error       : function(data){
                
                var response = $.parseJSON(data.responseText);
                if(response.success === true){
                    
                    Toast.fire({
                      icon: 'success',
                      title: response.message
                    });
                    $('#addBtn').html('Save').attr('disabled', false);
                    window.location.href = LISTING;
                    
                } else {
                    
                    Toast.fire({
                      icon: 'error',
                      title: response.message
                    });
                    
                    $.each(response.data, function(index, value){
                        $('#add_'+index+'_error').text(value);
                    });
                    
                    $('#addBtn').html('Save').attr('disabled', false);
                    
                }
            }

        });
        
        return false;
    });
    
    
    $(document.body).on('click', '.editRecord', function () {

        let recordId = $(this).data('id');
    
        $.ajax({
            url: EDIT_RECORD.replace(':id', recordId),
            method: 'GET',
            dataType: 'json',
    
            success: function (response) {
                if (response.success) {
    
                    $('#edit_id_input').val(response.data.id);
                    $('#edit_name_input').val(response.data.name);
                    $('#edit_terms_of_expense_input').val(response.data.terms_of_expense);
                    $('input[name="status"][value="' + response.data.status + '"]').prop('checked', true);
    
                    $('#editModal').modal('show');
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
    
            error: function (xhr) {
                console.log(xhr.responseText); // 
                Toast.fire({
                    icon: 'error',
                    title: 'Request failed. Check console.'
                });
            }
        });
    
    });

    
    
    
    
    
    $(document.body).on('click', '#updateBtn', function(){
        $('form#editForm').submit();
    });
    
    $('form#editForm').on('submit', function(){
        var formData = new FormData(this);
        $('.error').html('');
        $('#updateBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'application/json',
            success     : function(response){
                
            },
            error       : function(data){
                
                var response = $.parseJSON(data.responseText);
                if(response.success === true){
                    
                    Toast.fire({
                      icon: 'success',
                      title: response.message
                    });
                    $('#updateBtn').html('Update').attr('disabled', false);
                    window.location.href = LISTING;
                    
                } else {
                    
                    Toast.fire({
                      icon: 'error',
                      title: response.message,
                      width:'420px'
                    });
                    
                    $.each(response.data, function(index, value){
                        $('#edit_'+index+'_error').text(value);
                    });
                    
                    $('#updateBtn').html('Update').attr('disabled', false);
                    
                }
            }

        });
        
        return false;
    });
    
    
    
    
    
    
    
    
    
    
    
});



