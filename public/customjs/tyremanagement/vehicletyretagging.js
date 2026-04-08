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

$(document).ready(function(){
    const tyreSystem = new FleetTyre({
        container: '#container-img',
        selector: '#type',
     
        svgMap: {
            6: sixWheelTruckPath,
            10: tenWheelTruckPath
        }
    });
     
    // optional: listen save event
    // tyreSystem.onSave(function(data){
    //     console.log("Saved Data:", data);
    // });
    
    $('#type').on('change', function () {
        let val = $(this).val();
        $('.mandtory_tyre_positions').hide();
        $('.mandtory_tyre_positions').each(function(index){
            if(index < val){
                $(this).show();
            }
        })
    });
    
    $('#type').trigger('change');
    
    // svg clicking
    $(document).on('click', '.tyre-group', function() {
        // 1. Get the data-code (e.g., "D1")
        var targetId = $(this).attr('data-code');
        
        // 2. Select the target element by ID
        var $target = $('#' + targetId);
    
        if ($target.length) {
            // 3. Define the header height offset
            var headerHeight = 80;
    
            // 4. Calculate the position
            // offset().top gets the element's distance from the top of the document
            var targetOffset = $target.offset().top - headerHeight;
    
            // 5. Animate the scroll
            $('html, body').stop().animate({
                scrollTop: targetOffset
            }, 600); // 600ms for the scroll speed
            
            // glow effect
            if ($('.card').hasClass('active')){
                $('.card').removeClass('active');
            }
            $($target).addClass('active');
        }
    });
    
    // life percentage conditions
    $('.life-percent').each(function() {
        // Convert text to a number (removing any non-numeric characters if necessary)
        var value = parseFloat($(this).text());
    
        if (value >= 70) {
            // Value is 70 or higher
            $(this).addClass('badge-success');
        } 
        else if (value >= 30) {
            // Value is between 30 and 69.99
            $(this).addClass('badge-warning');
        } 
        else {
            // Value is less than 30
            $(this).addClass('badge-danger');
        }
    });
    
    // spare wrap
    $('.add-spare').click(function(){
        $('.spare-wrap').show();
    })
    
    $(document).on('click', '.submitBtn', function () {
        $('#addTyreForm').submit();
    });
    
    $('form#addTyreForm').on('submit', function(e){
        e.preventDefault();
        
        $('.submitBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        var formData = new FormData(this);
        $('.error').html('');
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
                    $('#add_'+index+'_error').text(value[0]);
                });
                
                $('.submitBtn').html('Save').attr('disabled', false);
            }

        });
        
        return false;
    });
});