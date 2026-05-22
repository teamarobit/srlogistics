
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
    

    // === BUG-019: daterangepicker for Start Date and End Date ===

    // Init start_date daterangepicker
    $('.start_date').daterangepicker({
        singleDatePicker : true,
        autoUpdateInput  : false,
        minDate          : moment(),
        locale           : { format: 'DD/MM/YYYY' }
    });

    // Init end_date daterangepicker
    $('.end_date').daterangepicker({
        singleDatePicker : true,
        autoUpdateInput  : false,
        locale           : { format: 'DD/MM/YYYY' }
    });

    $('.start_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
        $('#start_date_hidden').val(picker.startDate.format('YYYY-MM-DD'));
        calcEndDate();
    });

    $('.end_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
        $('#end_date_hidden').val(picker.startDate.format('YYYY-MM-DD'));
    });

    function calcEndDate() {
        let startVal     = $('.start_date').val();
        let contractType = $('#contract_type_id option:selected').text().trim();

        if (!startVal) return;

        let start = moment(startVal, 'DD/MM/YYYY');
        let end   = start.clone();

        if (contractType === 'Monthly')     end.add(1, 'months').subtract(1, 'days');
        if (contractType === 'Quarterly')   end.add(3, 'months').subtract(1, 'days');
        if (contractType === 'Half Yearly') end.add(6, 'months').subtract(1, 'days');
        if (contractType === 'Yearly')      end.add(1, 'years').subtract(1, 'days');

        if (['Monthly', 'Quarterly', 'Half Yearly', 'Yearly'].includes(contractType)) {
            $('.end_date').val(end.format('DD/MM/YYYY'));
            $('#end_date_hidden').val(end.format('YYYY-MM-DD'));
        }
    }
    
    
    
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
        calcEndDate();
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





