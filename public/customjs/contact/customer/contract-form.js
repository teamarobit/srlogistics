
$(document).ready(function () {
    
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
    

    // Get today in Y-m-d format
    function formatDate(date) {
        let d = new Date(date);
        let month = String(d.getMonth() + 1).padStart(2, '0');
        let day   = String(d.getDate()).padStart(2, '0');
        let year  = d.getFullYear();
        return year + '-' + month + '-' + day;
    }

    let today = formatDate(new Date());

    // Start date cannot be before today
    $('.start_date').attr('min', today);
    
    

    // When start date changes
    $(document).on('change', '.start_date', function () {

        let startDate = $(this).val();   // already in Y-m-d
        let $endDate  = $('.end_date');

        if (startDate !== '') {

            // Clear invalid end date
            let currentEnd = $endDate.val();
            if (currentEnd !== '' && currentEnd < startDate) {
                $endDate.val('');
            }

            // End date cannot be before start date
            $endDate.attr('min', startDate);

        } else {
            // Remove restriction if start date cleared
            $endDate.removeAttr('min');
        }

    });
    
    
    // When start date OR contract type changes
    $(document).on('change', '.start_date, #contract_type_id', function () {
    
        let startDate = $('.start_date').val();
        let contractType = $('#contract_type_id option:selected').text().trim();
        let $endDate = $('.end_date');
        
        if (startDate !== '') {

            let start = new Date(startDate);
            let calculatedEnd = new Date(start);
    
            if (contractType === 'Monthly') {
                calculatedEnd.setMonth(calculatedEnd.getMonth() + 1);
                calculatedEnd.setDate(calculatedEnd.getDate() - 1);
            }
            
            if (contractType === 'Yearly') {
                calculatedEnd.setFullYear(calculatedEnd.getFullYear() + 1);
                calculatedEnd.setDate(calculatedEnd.getDate() - 1);
            }
            
            // AUTO SET end date
            $endDate.val(formatDate(calculatedEnd));
    
            // Set min end date (always >= start date)
            $endDate.attr('min', formatDate(start));
    
        } else {
            $endDate.val('');
            $endDate.removeAttr('min');
        }
    
        // if (startDate !== '') {
    
        //     let minEndDate = new Date(startDate);
    
        //     // If Monthly -> add 30 days
        //     if (contractType === 'Monthly') {
        //         minEndDate.setDate(minEndDate.getDate() + 30);
        //     }
    
        //     let formattedMinEndDate = formatDate(minEndDate);
    
        //     // Clear invalid end date
        //     let currentEnd = $endDate.val();
        //     if (currentEnd !== '' && currentEnd < formattedMinEndDate) {
        //         $endDate.val('');
        //     }
    
        //     // Set new min
        //     $endDate.attr('min', formattedMinEndDate);
    
        // } else {
        //     $endDate.removeAttr('min');
        // }
    
    });
    
    
    
    $('.clickto-adclass').change(function(){
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').addClass('active');
        } else {
            $('.days-beforeexpiry').removeClass('active');
        }
    });
    
    $('#setReminder').on('change', function () {
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').slideDown();   // show div
        } else {
            $('.days-beforeexpiry').slideUp();     // hide div
        }
    });
    
    $('#contract_type_id').on('change', function () { 
        const selectedText = $(this).find('option:selected').text().trim();
        if (selectedText === 'Monthly') {
            $('#MonthlyDiv').show();
        } else {
            $('#MonthlyDiv').hide();
        }
    });
    
    
    
    
    $(document).on('click','#addContractBtn',function(e){
        e.preventDefault();
        $('form#addContractForm').submit();
    });
    
    $('form#addContractForm').on('submit', function(){
        var formData = new FormData(this);
        $('.error').html('');
        $('#addContractBtn').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                if (response.success === true) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
    
                    // REDIRECT WORKS
                    // Redirect to edit page using contract ID
                    var redirectUrl = EDIT_CONTRACT.replace(':id', response.data.contact_id);
                    window.location.href = redirectUrl;
                    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
    
                $('#addContractBtn').html('Save').attr('disabled', false);
            },
            error       : function(data){
                
                var response = $.parseJSON(data.responseText);
                if(response.success === true){
                    
                    Toast.fire({
                      icon: 'success',
                      title: response.message
                    });
                    $('#addContractBtn').html('Save').attr('disabled', false);
                    window.location.href = CONTRACTS;
                    
                } else {
                    
                    Toast.fire({
                      icon: 'error',
                      title: response.message
                    });
                    
                    $.each(response.data, function(index, value){
                        $('#add_'+index+'_error').text(value);
                    });
                    
                    $('#addContractBtn').html('Save').attr('disabled', false);
                    
                }
            }

        });
        
        return false;
    });
    
    
    
    
    
    
    
    
    
    
    
    $(document).on('click', '#editContractBtn', function (e) {
        e.preventDefault();
        $('#editContractForm').submit();
    });

    $('#editContractForm').on('submit', function (e) {
        e.preventDefault();
    
        let formData = new FormData(this);
    
        $('.error').html('');
        $('#editContractBtn')
            .html('<div class="spinner-border spinner-border-sm"></div>')
            .attr('disabled', true);
    
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json', // FIX
            success: function (response) {
    
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
    
                    // REDIRECT WORKS
                    window.location.reload();
                    return;
                }
    
                Toast.fire({
                    icon: 'error',
                    title: response.message
                });
    
                $('#editContractBtn').html('Save').attr('disabled', false);
            },
            error: function (xhr) {
    
                let response = xhr.responseJSON;
    
                Toast.fire({
                    icon: 'error',
                    title: response?.message || 'Something went wrong'
                });
    
                if (response?.data) {
                    $.each(response.data, function (key, value) {
                        $('#add_' + key + '_error').text(value[0]);
                    });
                }
    
                $('#editContractBtn').html('Save').attr('disabled', false);
            }
        });
    });

    
    
    

});





