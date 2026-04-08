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

Dropzone.autoDiscover = false;

const MAX_ATTACHMENTS = 4;
let attachmentIndex = 0;
let dzInstance = null;

function initDropzone() {
    const myDropzone = document.getElementById(`myDropzone`);
    if (!myDropzone) return;

    // Prevent double init
    if (myDropzone.dropzone) return;

    dzInstance = new Dropzone(myDropzone, {
        url: '/upload/images',
        paramName: "files",
        maxFiles: MAX_ATTACHMENTS,
        maxFilesize: 2,
        acceptedFiles: ".webp,.jpg,.jpeg,.png",
        addRemoveLinks: true,
        parallelUploads: MAX_ATTACHMENTS,
        autoProcessQueue: false,
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') }
    });
    
    // Event: file exceeds max
    dzInstance.on("maxfilesexceeded", function(file) {
        dzInstance.removeFile(file); // Remove the extra file
        Toast.fire({
                      icon: 'error',
                      title: "Maximum 2 attachments allowed!"
                    });
    });
}


$(document).ready(function() {
    initDropzone();
    
    $('.vendor_select').select2({
        placeholder: 'Select Vendor'
    });
    
    $(document).on('click', '.submitBtn', function () {
        $('#editTyreForm').submit();
    });
    
    $('form#editTyreForm').on('submit', function(e){
        e.preventDefault();
        
        $('.error').html('');
        $('.submitBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        var formData = new FormData(this);
        
        if($('#myDropzone').length){
            for (let i = 0; i < dzInstance.files.length; i++) {
                formData.append("files[]", dzInstance.files[i]); // Append each file properly
            }
        }
        
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                Toast.fire({
                  icon: 'success',
                  title: response.message,
                  didClose: function(){
                    window.location.href = response.redirect_url;
                  }
                });
                
                $('.submitBtn').html('Save');
            },
            error       : function(data){
                var response = data.responseJSON;
                
                Toast.fire({
                  icon: 'error',
                  title: response.message
                });
                
                $.each(response.data, function(index, value){
                    $('#edit_'+index+'_error').text(value[0]);
                });
                
                $('.submitBtn').html('Save').attr('disabled', false);
            }

        });
        
        return false;
    });


    
    


});









